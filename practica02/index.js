// Variables para el juego
let currentPlayer = 'X';
let board = ['', '', '', '', '', '', '', '', ''];
let isGameActive = true;
let gameStarted = false;
let timerInterval;
let startTime;
let userName;
let timeScores = []; // Arreglo para almacenar los puntajes temporales

// Elementos del DOM
const fields = document.querySelectorAll('.field');
const viewTime = document.querySelector('#view-time');
const viewScores = document.querySelector('#view-scores');

// Combinaciones ganadoras
const winningCombinations = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];

const saveScoreIfQualified = (time) => {
    const name = prompt('Ingresa tu nombre:');
    if (!name) {
        console.error("Nombre del jugador no proporcionado.");
        return;
    }
    const gameName = "Tic-Tac-Toe-Alan";

    // Enviar los datos al servidor
    enviarPuntaje(time, name, gameName);
};

const enviarPuntaje = (score, player, game) => {
    const params = new URLSearchParams();
    params.append("score", score);
    params.append("player", player);
    params.append("game", game);

    fetch("http://primosoft.com.mx/games/api/addscore.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Error al enviar puntaje: ${response.status} ${response.statusText}`);
            }
            return response.text();
        })
        .then((data) => {
            console.log("Puntaje enviado exitosamente:", data);
        })
        .catch((error) => {
            console.error("Hubo un problema con la solicitud:", error);
        });
};

const displayScores = () => {
    fetch("ver-scores.php")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Error al obtener puntajes: ${response.status} ${response.statusText}`);
            }
            return response.json();
        })
        .then((scores) => {
            if (scores.error) {
                viewScores.innerHTML = scores.error;
                return;
            }

            if (!scores || scores.length === 0) {
                viewScores.innerHTML = "No hay puntajes disponibles.";
                return;
            }

            // Mostrar puntajes en el DOM
            viewScores.innerHTML = scores
                .map((score, index) => 
                    `${index + 1}.- ${score.player} - ${formatTime(score.score)} - ${score.date}`
                )
                .join('<br>');
        })
        .catch((error) => {
            console.error("Error al obtener los puntajes:", error);
            viewScores.innerHTML = "Error al cargar los puntajes. Por favor, intenta más tarde.";
        });
};


const checkWinner = () => {
    let roundWon = false;
    for (let i = 0; i < winningCombinations.length; i++) {
        const winCondition = winningCombinations[i];
        const a = board[winCondition[0]];
        const b = board[winCondition[1]];
        const c = board[winCondition[2]];
        
        if (a === '' || b === '' || c === '') {
            continue;
        }
        if (a === b && b === c) {
            roundWon = true;
            break;
        }
    }

    if (roundWon) {
        stopTimer();
        const elapsedTime = Date.now() - startTime;
        if (currentPlayer === 'X') {
            saveScoreIfQualified(elapsedTime);
        }
        isGameActive = false;
    } else if (!board.includes('')) {
        stopTimer();
        isGameActive = false; 
    }
};

// Función para manejar clic en los campos
const handleFieldClick = (e) => {
    const field = e.target;
    const index = field.getAttribute('id').replace('fieldP', '') - 1;

    if (board[index] === '' && isGameActive) {
        if (!gameStarted) {
            startTimer();
            gameStarted = true;
        }
        board[index] = currentPlayer;
        field.textContent = currentPlayer;

        checkWinner();

        if (isGameActive) {
            currentPlayer = 'O';
            computerTurn();
        }
    }
};

// Turno de la computadora (jugador O)
const computerTurn = () => {
    setTimeout(() => {
        let availableFields = [];
        board.forEach((value, index) => {
            if (value === '') availableFields.push(index);
        });

        if (availableFields.length > 0 && isGameActive) {
            const randomIndex = Math.floor(Math.random() * availableFields.length);
            const fieldIndex = availableFields[randomIndex];
            board[fieldIndex] = 'O';
            document.getElementById(`fieldP${fieldIndex + 1}`).textContent = 'O';
            checkWinner();
            currentPlayer = 'X';
        }
    });
};

// Reiniciar el juego
const resetGame = () => {
    board = ['', '', '', '', '', '', '', '', ''];
    fields.forEach(field => field.textContent = '');
    currentPlayer = 'X';
    isGameActive = true;
    gameStarted = false;
    viewTime.textContent = '0:00.000';
    stopTimer();
    //localStorage.clear();
};

// Funciones para el cronómetro
const startTimer = () => {
    startTime = Date.now();
    timerInterval = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        viewTime.textContent = formatTime(elapsedTime);
    }, 10);
};

const stopTimer = () => {
    clearInterval(timerInterval);
};

const formatTime = (milliseconds) => {
    const totalSeconds = Math.floor(milliseconds / 1000);
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    const ms = milliseconds % 1000;
    return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}.${ms < 100 ? '0' : ''}${ms < 10 ? '0' : ''}${ms}`;
};

fields.forEach(field => field.addEventListener('click', handleFieldClick));
window.addEventListener('load', () => {
    resetGame();
    displayScores();
});
