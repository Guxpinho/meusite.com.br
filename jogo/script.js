const gameBoard = document.getElementById('game-board');
const startScreen = document.getElementById('start-screen');
const startButton = document.getElementById('start-button');
const gameContainer = document.getElementById('game-container');
const restartButton = document.getElementById('restart-button');
const turnDisplay = document.getElementById('turn-display');
const redPiecesDisplay = document.getElementById('red-pieces');
const blackPiecesDisplay = document.getElementById('black-pieces');
const gameModeDisplay = document.getElementById('game-mode-display');
const modeButtons = document.querySelectorAll('.mode-button');

const board = [];
let selectedPiece = null;
let turn = 'black';
let redPieces = 12;
let blackPieces = 12;
let mustCapture = false;
let gameMode = 'player';
let isAiThinking = false;

// Event listeners
startButton.addEventListener('click', startGame);
restartButton.addEventListener('click', restartGame);

modeButtons.forEach(button => {
    button.addEventListener('click', () => {
        modeButtons.forEach(btn => btn.classList.remove('selected'));
        button.classList.add('selected');
        gameMode = button.dataset.mode;
    });
});

function startGame() {
    startScreen.style.display = 'none';
    gameContainer.style.display = 'flex';
    initializeGame();
}

function restartGame() {
    gameBoard.innerHTML = '';
    board.length = 0;
    selectedPiece = null;
    turn = 'black';
    redPieces = 12;
    blackPieces = 12;
    mustCapture = false;
    isAiThinking = false;
    initializeGame();
}

function initializeGame() {
    createBoard();
    updateDisplay();
}

function createBoard() {
    for (let row = 0; row < 8; row++) {
        board[row] = [];
        for (let col = 0; col < 8; col++) {
            const square = document.createElement('div');
            square.classList.add('square');
            square.dataset.row = row;
            square.dataset.col = col;

            if ((row + col) % 2 === 0) {
                square.classList.add('light');
                board[row][col] = null;
            } else {
                square.classList.add('dark');
                if (row < 3) {
                    const piece = createPiece('red');
                    square.appendChild(piece);
                    board[row][col] = { color: 'red', isKing: false };
                } else if (row > 4) {
                    const piece = createPiece('black');
                    square.appendChild(piece);
                    board[row][col] = { color: 'black', isKing: false };
                } else {
                    board[row][col] = null;
                }
            }
            square.addEventListener('click', handleSquareClick);
            gameBoard.appendChild(square);
        }
    }
}

function createPiece(color) {
    const piece = document.createElement('div');
    piece.classList.add('piece', `${color}-piece`);
    piece.dataset.color = color;
    piece.dataset.isKing = 'false';
    piece.addEventListener('click', handlePieceClick);
    return piece;
}

function handlePieceClick(event) {
    event.stopPropagation();
    const piece = event.target;

    if (isAiThinking || (gameMode !== 'player' && turn === 'red')) {
        return;
    }

    if (piece.dataset.color !== turn) {
        alert('Não é a sua vez de jogar!');
        return;
    }

    if (selectedPiece) {
        selectedPiece.classList.remove('selected');
        clearPossibleMoves();
    }
    
    selectedPiece = piece;
    selectedPiece.classList.add('selected');
    showPossibleMoves();
}

function handleSquareClick(event) {
    const square = event.target;
    if (!selectedPiece || !square.classList.contains('possible-move') || isAiThinking) {
        return;
    }

    makeMove(selectedPiece, square);
}

function makeMove(piece, targetSquare) {
    const startSquare = piece.parentElement;
    const startRow = parseInt(startSquare.dataset.row);
    const startCol = parseInt(startSquare.dataset.col);
    const destRow = parseInt(targetSquare.dataset.row);
    const destCol = parseInt(targetSquare.dataset.col);

    const rowDiff = Math.abs(destRow - startRow);
    const isCapture = rowDiff > 1;

    if (isCapture) {
        const capturedPositions = getCapturePath(startRow, startCol, destRow, destCol);
        capturedPositions.forEach(pos => {
            const capturedSquare = gameBoard.children[pos.row * 8 + pos.col];
            const capturedPiece = capturedSquare.querySelector('.piece');
            if (capturedPiece) {
                capturedSquare.removeChild(capturedPiece);
                board[pos.row][pos.col] = null;
                if (capturedPiece.dataset.color === 'red') {
                    redPieces--;
                } else {
                    blackPieces--;
                }
            }
        });
    }

    // Move a peça no DOM e no board
    board[startRow][startCol] = null;
    targetSquare.appendChild(piece);
    board[destRow][destCol] = { color: piece.dataset.color, isKing: piece.dataset.isKing === 'true' };

    checkIfKing(piece, destRow);
    
    piece.classList.remove('selected');
    clearPossibleMoves();
    
    if (isCapture && canMakeMoreCaptures(piece, destRow, destCol)) {
        selectedPiece = piece;
        piece.classList.add('selected');
        showPossibleMoves();
    } else {
        selectedPiece = null;
        switchTurn();
    }
}

function showPossibleMoves() {
    clearPossibleMoves();
    if (!selectedPiece) return;

    const startSquare = selectedPiece.parentElement;
    const startRow = parseInt(startSquare.dataset.row);
    const startCol = parseInt(startSquare.dataset.col);

    mustCapture = checkAllPiecesForCaptures(turn);
    let pieceHasCapture = findCapturesForPiece(startRow, startCol).length > 0;

    if (mustCapture && pieceHasCapture) {
        const captures = findCapturesForPiece(startRow, startCol);
        captures.forEach(move => {
            const square = gameBoard.children[move.destRow * 8 + move.destCol];
            square.classList.add('possible-move');
        });
    } else if (!mustCapture) {
        const moves = findSimpleMovesForPiece(startRow, startCol);
        moves.forEach(move => {
            const square = gameBoard.children[move.destRow * 8 + move.destCol];
            square.classList.add('possible-move');
        });
    }
}

function findSimpleMovesForPiece(row, col) {
    const moves = [];
    const piece = board[row][col];
    if (!piece) return moves;

    const isKing = piece.isKing;
    const directions = isKing ? [[-1, -1], [-1, 1], [1, -1], [1, 1]] : 
                     (piece.color === 'black' ? [[-1, -1], [-1, 1]] : [[1, -1], [1, 1]]);

    for (const dir of directions) {
        const newRow = row + dir[0];
        const newCol = col + dir[1];
        if (newRow >= 0 && newRow < 8 && newCol >= 0 && newCol < 8 && !board[newRow][newCol]) {
            moves.push({destRow: newRow, destCol: newCol});
        }
    }
    return moves;
}

function findCapturesForPiece(row, col) {
    const captures = [];
    const piece = board[row][col];
    if (!piece) return captures;

    const color = piece.color;
    const isKing = piece.isKing;
    // Peças comuns podem capturar em todas as direções (incluindo para trás)
    // Dama também pode capturar em todas as direções
    const directions = [[-1, -1], [-1, 1], [1, -1], [1, 1]];

    for (const dir of directions) {
        // Tanto peça comum quanto dama: captura apenas uma casa após a peça capturada
        const middleRow = row + dir[0];
        const middleCol = col + dir[1];
        const destRow = row + 2 * dir[0];
        const destCol = col + 2 * dir[1];

        if (destRow >= 0 && destRow < 8 && destCol >= 0 && destCol < 8) {
            const middlePiece = board[middleRow][middleCol];
            const targetPiece = board[destRow][destCol];

            if (middlePiece && middlePiece.color !== color && !targetPiece) {
                captures.push({destRow, destCol});
            }
        }
    }
    return captures;
}

function getCapturePath(startRow, startCol, destRow, destCol) {
    const path = [];
    const rowDirection = Math.sign(destRow - startRow);
    const colDirection = Math.sign(destCol - startCol);
    let currentRow = startRow + rowDirection;
    let currentCol = startCol + colDirection;
    
    while (currentRow !== destRow || currentCol !== destCol) {
        if (board[currentRow][currentCol]) {
            path.push({row: currentRow, col: currentCol});
        }
        currentRow += rowDirection;
        currentCol += colDirection;
    }
    return path;
}

function clearPossibleMoves() {
    document.querySelectorAll('.possible-move').forEach(square => {
        square.classList.remove('possible-move');
    });
}

function checkIfKing(piece, row) {
    const color = piece.dataset.color;
    if (color === 'red' && row === 7 && piece.dataset.isKing === 'false') {
        piece.dataset.isKing = 'true';
        piece.classList.add('king');
        board[row][parseInt(piece.parentElement.dataset.col)].isKing = true;
    } else if (color === 'black' && row === 0 && piece.dataset.isKing === 'false') {
        piece.dataset.isKing = 'true';
        piece.classList.add('king');
        board[row][parseInt(piece.parentElement.dataset.col)].isKing = true;
    }
}

function switchTurn() {
    turn = turn === 'red' ? 'black' : 'red';
    updateDisplay();
    
    if (!checkPlayerMoves(turn)) {
        endGame(turn === 'red' ? 'black' : 'red');
        return;
    }

    if (gameMode !== 'player' && turn === 'red') {
        setTimeout(() => makeAIMove(), 1000);
    }
}

function updateDisplay() {
    const playerName = turn === 'black' ? 'Preto' : 'Vermelho';
    turnDisplay.textContent = `Vez do Jogador ${playerName}`;
    redPiecesDisplay.textContent = `Peças Vermelhas: ${redPieces}`;
    blackPiecesDisplay.textContent = `Peças Pretas: ${blackPieces}`;
    
    const modeNames = {
        'player': 'Jogador vs Jogador',
        'easy': 'vs IA Fácil',
        'medium': 'vs IA Médio',
        'hard': 'vs IA Difícil'
    };
    gameModeDisplay.textContent = `Modo: ${modeNames[gameMode]}`;
}

function checkAllPiecesForCaptures(player) {
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const piece = board[row][col];
            if (piece && piece.color === player) {
                if (findCapturesForPiece(row, col).length > 0) {
                    return true;
                }
            }
        }
    }
    return false;
}

function canMakeMoreCaptures(piece, row, col) {
    const captures = findCapturesForPiece(row, col);
    return captures.length > 0;
}

function checkPlayerMoves(player) {
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const piece = board[row][col];
            if (piece && piece.color === player) {
                if (findCapturesForPiece(row, col).length > 0 || findSimpleMovesForPiece(row, col).length > 0) {
                    return true;
                }
            }
        }
    }
    return false;
}

function endGame(winner) {
    setTimeout(() => {
        alert(`Fim de jogo! O jogador ${winner.charAt(0).toUpperCase() + winner.slice(1)} venceu!`);
        restartGame();
    }, 100);
}

// ===============================
// LÓGICA DA INTELIGÊNCIA ARTIFICIAL
// ===============================

function makeAIMove() {
    if (isAiThinking) return;
    isAiThinking = true;
    
    // Adiciona efeito visual
    document.querySelectorAll('.red-piece').forEach(piece => {
        piece.parentElement.classList.add('ai-thinking');
    });

    const move = getBestMove(gameMode);
    
    setTimeout(() => {
        document.querySelectorAll('.ai-thinking').forEach(square => {
            square.classList.remove('ai-thinking');
        });
        
        if (move) {
            executeAIMove(move);
        }
        isAiThinking = false;
    }, 1000);
}

function getBestMove(difficulty) {
    const allMoves = getAllPossibleMoves('red');
    if (allMoves.length === 0) return null;

    switch (difficulty) {
        case 'easy':
            return allMoves[Math.floor(Math.random() * allMoves.length)];
        case 'medium':
            return getMediumMove(allMoves);
        case 'hard':
            return getHardMove(allMoves);
        default:
            return allMoves[0];
    }
}

function getAllPossibleMoves(color) {
    const moves = [];
    const hasCaptures = checkAllPiecesForCaptures(color);
    
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const piece = board[row][col];
            if (piece && piece.color === color) {
                if (hasCaptures) {
                    const captures = findCapturesForPiece(row, col);
                    captures.forEach(capture => {
                        moves.push({
                            fromRow: row,
                            fromCol: col,
                            toRow: capture.destRow,
                            toCol: capture.destCol,
                            isCapture: true
                        });
                    });
                } else {
                    const simpleMoves = findSimpleMovesForPiece(row, col);
                    simpleMoves.forEach(move => {
                        moves.push({
                            fromRow: row,
                            fromCol: col,
                            toRow: move.destRow,
                            toCol: move.destCol,
                            isCapture: false
                        });
                    });
                }
            }
        }
    }
    return moves;
}

function getMediumMove(moves) {
    // Prioriza capturas e movimentos que levam a dama
    const captureMoves = moves.filter(move => move.isCapture);
    if (captureMoves.length > 0) {
        return captureMoves[Math.floor(Math.random() * captureMoves.length)];
    }
    
    const kingMoves = moves.filter(move => move.toRow === 7);
    if (kingMoves.length > 0) {
        return kingMoves[Math.floor(Math.random() * kingMoves.length)];
    }
    
    return moves[Math.floor(Math.random() * moves.length)];
}

function getHardMove(moves) {
    // Implementa uma versão simplificada do minimax
    let bestMove = null;
    let bestScore = -Infinity;
    
    moves.forEach(move => {
        const score = evaluateMove(move);
        if (score > bestScore) {
            bestScore = score;
            bestMove = move;
        }
    });
    
    return bestMove;
}

function evaluateMove(move) {
    let score = 0;
    
    // Favorece capturas
    if (move.isCapture) {
        score += 10;
    }
    
    // Favorece movimento para se tornar dama
    if (move.toRow === 7) {
        score += 5;
    }
    
    // Favorece movimentos centrais
    const centerDistance = Math.abs(3.5 - move.toCol);
    score += (3.5 - centerDistance);
    
    // Favorece avançar
    score += (7 - move.toRow);
    
    return score + Math.random() * 2; // Adiciona aleatoriedade
}

function executeAIMove(move) {
    const fromSquare = gameBoard.children[move.fromRow * 8 + move.fromCol];
    const toSquare = gameBoard.children[move.toRow * 8 + move.toCol];
    const piece = fromSquare.querySelector('.piece');
    
    if (piece) {
        makeMove(piece, toSquare);
    }
}