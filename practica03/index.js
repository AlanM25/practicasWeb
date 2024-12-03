let numRows, numCols, numMines;
let board = [];
let firstClick = true;
let gameActive = true;

const gameBoard = document.getElementById("gameBoard");
const startGameButton = document.getElementById("startGame");
const difficultySelect = document.getElementById("difficulty");
const customSettings = document.getElementById("customSettings");
const rowsInput = document.getElementById("rows");
const colsInput = document.getElementById("cols");
const minesInput = document.getElementById("mines");

difficultySelect.addEventListener("change", () => {
    if (difficultySelect.value === "custom") {
        customSettings.style.display = "block";
    } else {
        customSettings.style.display = "none";
    }
});

startGameButton.addEventListener("click", () => {
    const difficulty = difficultySelect.value;
    switch (difficulty) {
        case "easy":
            numRows = 8;
            numCols = 8;
            numMines = 10;
            break;
        case "medium":
            numRows = 16;
            numCols = 16;
            numMines = 40;
            break;
        case "hard":
            numRows = 16;
            numCols = 30;
            numMines = 99;
            break;
        case "veryHard":
            numRows = 24;
            numCols = 24;
            numMines = 150;
            break;
        case "hardcore":
            numRows = 35;
            numCols = 35;
            numMines = 350;
            break;
        case "legend":
            numRows = 40;
            numCols = 40;
            numMines = 400;
            break;
        case "custom":
            numRows = parseInt(rowsInput.value);
            numCols = parseInt(colsInput.value);
            numMines = parseInt(minesInput.value);
            break;
    }
    initializeBoard();
    renderBoard();
});

function initializeBoard() {
    board = [];
    firstClick = true;
    gameActive = true;

    for (let i = 0; i < numRows; i++) {
        board[i] = [];
        for (let j = 0; j < numCols; j++) {
            board[i][j] = {
                isMine: false,
                revealed: false,
                count: 0,
                flagged: false,
            };
        }
    }
}

function placeMines(firstRow, firstCol) {
    let minesPlaced = 0;
    while (minesPlaced < numMines) {
        const row = Math.floor(Math.random() * numRows);
        const col = Math.floor(Math.random() * numCols);
        if (!board[row][col].isMine && !(row === firstRow && col === firstCol)) {
            board[row][col].isMine = true;
            minesPlaced++;
        }
    }
}

function calculateCounts() {
    for (let i = 0; i < numRows; i++) {
        for (let j = 0; j < numCols; j++) {
            if (!board[i][j].isMine) {
                let count = 0;
                for (let dx = -1; dx <= 1; dx++) {
                    for (let dy = -1; dy <= 1; dy++) {
                        const ni = i + dx;
                        const nj = j + dy;
                        if (ni >= 0 && ni < numRows && nj >= 0 && nj < numCols && board[ni][nj].isMine) {
                        count++;
                        }
                    }
                }
                board[i][j].count = count;
            }
        }
    }
}

function revealCell(row, col) {
    if (!gameActive || row < 0 || row >= numRows || col < 0 || col >= numCols || board[row][col].revealed || board[row][col].flagged) {
        return;
    }

    if (firstClick) {
        placeMines(row, col);
        calculateCounts();
        firstClick = false;
    }

    board[row][col].revealed = true;

    if (board[row][col].isMine) {
        revealAllMines();
        alert("Perdiste!!. Caíste en una mina");
        gameActive = false;
        startGameButton.disabled = false; // Habilitar el botón para reiniciar el juego
    } else if (board[row][col].count === 0) {
        for (let dx = -1; dx <= 1; dx++) {
            for (let dy = -1; dy <= 1; dy++) {
                revealCell(row + dx, col + dy);
            }
        }
    }

    renderBoard();
    checkWin();
}

function checkWin() {
    let revealedCells = 0;
    let totalCells = 0;

    for (let i = 0; i < numRows; i++) {
        for (let j = 0; j < numCols; j++) {
            if (board[i][j].revealed) {
                revealedCells++;
            }
            if (! board[i][j].isMine) {
                totalCells++;
            }
        }
    }

    if (revealedCells === totalCells) {
        alert("Ganaste chavo!!");
        gameActive = false; 
        startGameButton.disabled = false; 
    }
}

function flagCell(row, col) {
    if (row < 0 || row >= numRows || col < 0 || col >= numCols || board[row][col].revealed) {
        return;
    }

    board[row][col].flagged = !board[row][col].flagged;
    renderBoard();
}

function revealAllMines() {
    for (let i = 0; i < numRows; i++) {
        for (let j = 0; j < numCols; j++) {
            if (board[i][j].isMine) {
                board[i][j].revealed = true;
            }
        }
    }
}

function renderBoard() {
    gameBoard.innerHTML = "";

    for (let i = 0; i < numRows; i++) {
        for (let j = 0; j < numCols; j++) {
            const cell = document.createElement("div");
            cell.className = "cell";
            if (board[i][j].revealed) {
                cell.classList.add("revealed");
                if (board[i][j].isMine) {
                    cell.classList.add("mine");
                    cell.textContent = "💣";
                } else if (board[i][j].count > 0) {
                    cell.textContent = board[i][j].count;
                }
            } else if (board[i][j].flagged) {
                cell.classList.add("flag");
                cell.textContent = "🚩";
            }
            if (gameActive) {
                cell.addEventListener("click", () => revealCell(i, j));
                cell.addEventListener("contextmenu", (e) => {
                    e.preventDefault();
                    flagCell(i, j);
                });
            }
            gameBoard.appendChild(cell);
        }
        gameBoard.appendChild(document.createElement("br"));
    }
}