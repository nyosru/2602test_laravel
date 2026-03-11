<template>
    <div class="sudoku-game">
        <h1>Судоку <img src="/img/cat.png" class="cat-icon" /> <a href="https://php-cat.com" class="up_link" target="_blank" >php-cat.com</a></h1>

        <div class="game-container">
            <div v-if="hasWon" class="victory-overlay">
                <div class="fireworks">
                    <span class="firework firework-a"></span>
                    <span class="firework firework-b"></span>
                    <span class="firework firework-c"></span>
                </div>
                <div class="victory-modal">
                    <div class="victory-title">Победа!</div>
                    <button class="victory-button" @click="generateNewGame">
                        Начать новую игру
                    </button>
                </div>
            </div>

            <div class="sudoku-grid">
                <div
                    v-for="(row, rowIndex) in board"
                    :key="rowIndex"
                    class="sudoku-row"
                    :class="{ 'bottom-border': (rowIndex + 1) % 3 === 0 && rowIndex !== 8 }"
                >
                    <div
                        v-for="(cell, colIndex) in row"
                        :key="colIndex"
                        class="sudoku-cell"
                        :class="{
              'right-border': (colIndex + 1) % 3 === 0 && colIndex !== 8,
              'selected': selectedCell?.row === rowIndex && selectedCell?.col === colIndex,
              'highlighted': isCellHighlighted(rowIndex, colIndex),
              'fixed': cell.isFixed,
              'error': cell.isError,
              'same-value': isSameValue(rowIndex, colIndex)
            }"
                        @click="selectCell(rowIndex, colIndex)"
                    >
                        <template v-if="cell.value !== 0">
                            <span class="cell-value">{{ cell.value }}</span>
                        </template>
                        <template v-else-if="cell.notes.length > 0">
                            <div class="notes-container">
                                <div
                                    v-for="num in 9"
                                    :key="num"
                                    class="note"
                                    :class="{ 'active': cell.notes.includes(num) }"
                                >
                                    {{ num }}
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="controls">
                <div class="number-pad">
                    <button
                        v-for="num in 9"
                        :key="num"
                        @click="setNumber(num)"
                        :disabled="gameOver || hasWon || !selectedCell || board[selectedCell.row][selectedCell.col].isFixed"
                        class="number-btn"
                        :class="{ 'completed-number': isNumberCompleted(num) }"
                    >
                        {{ num }}
                    </button>
                    <button
                        @click="clearCell"
                        :disabled="gameOver || hasWon || !selectedCell || board[selectedCell.row][selectedCell.col].isFixed"
                        class="number-btn clear-btn"
                    >
                        ⌫
                    </button>
                </div>

                <div class="action-buttons">
                    <button @click="toggleNoteMode" :class="{ 'active': noteMode }" :disabled="gameOver || hasWon">
                        📝 Режим заметок
                    </button>
                    <button @click="addNotesToAllEmpty" :disabled="gameOver || hasWon">
                        📋 Заметки во все пустые поля
                    </button>
                    <button @click="clearAllNotes" :disabled="gameOver || hasWon">
                        🗑️ Очистить все заметки
                    </button>
                    <button @click="undoLastMove" :disabled="history.length === 0">
                        ↩ Отмена последней цифры
                    </button>
                    <button @click="generateNewGame">
                        🔄 Новая игра
                    </button>
                    <button @click="checkSolution" :disabled="gameOver || hasWon">
                        ✓ Проверить
                    </button>
                </div>

                <div class="mistakes-counter" :class="{ 'limit-reached': gameOver }">
                    Ошибки: {{ mistakes }} / {{ maxMistakes }}
                </div>

                <div class="difficulty-selector">
                    <span>Сложность:</span>
                    <button
                        @click="setDifficulty('easy')"
                        :class="{ 'active': difficulty === 'easy' }"
                    >
                        Легкая
                    </button>
                    <button
                        @click="setDifficulty('medium')"
                        :class="{ 'active': difficulty === 'medium' }"
                    >
                        Средняя
                    </button>
                    <button
                        @click="setDifficulty('hard')"
                        :class="{ 'active': difficulty === 'hard' }"
                    >
                        Сложная
                    </button>
                </div>

                <div class="keyboard-hint">
                    <span>💡 Подсказка: Используйте цифры на клавиатуре (1-9) и Backspace для удаления</span>
                </div>

                <div v-if="message" class="message" :class="{ 'error': isError }">
                    {{ message }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
    name: 'SudokuGame',
    setup() {
        const board = ref([])
        const selectedCell = ref(null)
        const noteMode = ref(false)
        const message = ref('')
        const isError = ref(false)
        const difficulty = ref('medium')
        const mistakes = ref(0)
        const maxMistakes = 3
        const gameOver = ref(false)
        const hasWon = ref(false)
        const history = ref([])

        // Генератор полностью заполненного судоку
        const generateFullSudoku = () => {
            const grid = Array(9).fill().map(() => Array(9).fill(0))

            // Заполняем диагональные блоки 3x3 (они независимы)
            for (let block = 0; block < 9; block += 3) {
                fillBlock(grid, block, block)
            }

            // Решаем остальные ячейки
            solveSudoku(grid)

            return grid
        }

        // Заполнение блока 3x3 случайными числами
        const fillBlock = (grid, startRow, startCol) => {
            const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9]
            shuffleArray(numbers)

            let index = 0
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    grid[startRow + i][startCol + j] = numbers[index++]
                }
            }
        }

        // Перемешивание массива (алгоритм Фишера-Йейтса)
        const shuffleArray = (array) => {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]]
            }
        }

        // Решение судоку (для заполнения)
        const solveSudoku = (grid) => {
            const findEmpty = () => {
                for (let row = 0; row < 9; row++) {
                    for (let col = 0; col < 9; col++) {
                        if (grid[row][col] === 0) return [row, col]
                    }
                }
                return null
            }

            const isValid = (row, col, num) => {
                // Проверка строки
                for (let x = 0; x < 9; x++) {
                    if (grid[row][x] === num) return false
                }

                // Проверка столбца
                for (let x = 0; x < 9; x++) {
                    if (grid[x][col] === num) return false
                }

                // Проверка блока 3x3
                const startRow = Math.floor(row / 3) * 3
                const startCol = Math.floor(col / 3) * 3
                for (let i = 0; i < 3; i++) {
                    for (let j = 0; j < 3; j++) {
                        if (grid[startRow + i][startCol + j] === num) return false
                    }
                }

                return true
            }

            const solve = () => {
                const empty = findEmpty()
                if (!empty) return true

                const [row, col] = empty
                const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9]
                shuffleArray(numbers)

                for (const num of numbers) {
                    if (isValid(row, col, num)) {
                        grid[row][col] = num

                        if (solve()) {
                            return true
                        }

                        grid[row][col] = 0
                    }
                }

                return false
            }

            solve()
        }

        // Создание игрового поля с удаленными ячейками в зависимости от сложности
        const createPuzzle = (fullGrid) => {
            // Количество удаляемых ячеек в зависимости от сложности
            const cellsToRemove = {
                easy: 40,
                medium: 50,
                hard: 60
            }

            // Копируем полное решение
            const puzzle = fullGrid.map(row => [...row])

            // Создаем массив всех позиций
            const positions = []
            for (let i = 0; i < 9; i++) {
                for (let j = 0; j < 9; j++) {
                    positions.push([i, j])
                }
            }

            // Перемешиваем позиции
            shuffleArray(positions)

            // Удаляем ячейки
            const removeCount = cellsToRemove[difficulty.value]
            for (let i = 0; i < removeCount; i++) {
                const [row, col] = positions[i]
                puzzle[row][col] = 0
            }

            return puzzle
        }

        // Создание игрового поля с заметками и флагами
        const createBoardFromPuzzle = (puzzle) => {
            return puzzle.map(row =>
                row.map(value => ({
                    value,
                    notes: [],
                    isFixed: value !== 0,
                    isError: false
                }))
            )
        }

        // Генерация новой игры
        const generateNewGame = () => {
            const fullGrid = generateFullSudoku()
            const puzzle = createPuzzle(fullGrid)
            board.value = createBoardFromPuzzle(puzzle)
            selectedCell.value = null
            noteMode.value = false
            mistakes.value = 0
            gameOver.value = false
            hasWon.value = false
            history.value = []
            message.value = 'Новая игра сгенерирована!'
            isError.value = false
            setTimeout(() => { message.value = '' }, 2000)
        }

        // Установка сложности
        const setDifficulty = (level) => {
            difficulty.value = level
            generateNewGame()
        }

        // Обработчик нажатий клавиш
        const handleKeyDown = (event) => {
            if (gameOver.value || hasWon.value) {
                return
            }

            // Проверяем, что выбрана ячейка
            if (!selectedCell.value) {
                return
            }

            const { row, col } = selectedCell.value
            const cell = board.value[row][col]

            // Нельзя изменять фиксированные ячейки
            if (cell.isFixed) {
                return
            }

            // Цифры 1-9
            if (event.key >= '1' && event.key <= '9') {
                event.preventDefault() // Предотвращаем ввод в возможные поля ввода
                const num = parseInt(event.key)
                setNumber(num)
            }

            // Backspace для удаления
            else if (event.key === 'Backspace' || event.key === 'Delete') {
                event.preventDefault()
                clearCell()
            }

            // Клавиша N для переключения режима заметок
            else if (event.key === 'n' || event.key === 'N') {
                event.preventDefault()
                toggleNoteMode()
            }

            // Стрелки для навигации
            else if (event.key.startsWith('Arrow')) {
                event.preventDefault()
                navigateWithArrows(event.key)
            }
        }

        // Навигация с помощью стрелок
        const navigateWithArrows = (key) => {
            if (!selectedCell.value) {
                // Если ничего не выбрано, выбираем центр
                selectCell(4, 4)
                return
            }

            let { row, col } = selectedCell.value

            switch (key) {
                case 'ArrowUp':
                    row = Math.max(0, row - 1)
                    break
                case 'ArrowDown':
                    row = Math.min(8, row + 1)
                    break
                case 'ArrowLeft':
                    col = Math.max(0, col - 1)
                    break
                case 'ArrowRight':
                    col = Math.min(8, col + 1)
                    break
            }

            selectCell(row, col)
        }

        // Добавляем и удаляем обработчик событий клавиатуры
        onMounted(() => {
            generateNewGame()
            window.addEventListener('keydown', handleKeyDown)
        })

        onUnmounted(() => {
            window.removeEventListener('keydown', handleKeyDown)
        })

        const selectCell = (row, col) => {
            if (gameOver.value || hasWon.value) return
            selectedCell.value = { row, col }
        }

        const cloneBoardState = () => {
            return board.value.map(row =>
                row.map(cell => ({
                    ...cell,
                    notes: [...cell.notes]
                }))
            )
        }

        const saveHistorySnapshot = () => {
            history.value.push({
                board: cloneBoardState(),
                mistakes: mistakes.value,
                gameOver: gameOver.value,
                hasWon: hasWon.value,
                selectedCell: selectedCell.value ? { ...selectedCell.value } : null
            })
        }

        const countPlacedNumber = (num) => {
            let count = 0

            for (const row of board.value) {
                for (const cell of row) {
                    if (cell.value === num) {
                        count += 1
                    }
                }
            }

            return count
        }

        const isNumberCompleted = (num) => countPlacedNumber(num) === 9

        const isBoardFilled = () => {
            for (const row of board.value) {
                for (const cell of row) {
                    if (cell.value === 0) {
                        return false
                    }
                }
            }

            return true
        }

        const triggerVictory = () => {
            hasWon.value = true
            noteMode.value = false
            selectedCell.value = null
            message.value = 'Победа!'
            isError.value = false
        }

        const isCellHighlighted = (row, col) => {
            if (!selectedCell.value) return false
            const { row: selectedRow, col: selectedCol } = selectedCell.value
            return row === selectedRow || col === selectedCol ||
                (Math.floor(row / 3) === Math.floor(selectedRow / 3) &&
                    Math.floor(col / 3) === Math.floor(selectedCol / 3))
        }

        const isSameValue = (row, col) => {
            if (!selectedCell.value) return false
            const selectedValue = board.value[selectedCell.value.row][selectedCell.value.col].value
            if (selectedValue === 0) return false
            return board.value[row][col].value === selectedValue
        }

        const removeNotesFromRelatedCells = (row, col, num) => {
            board.value[row][col].notes = board.value[row][col].notes.filter(n => n !== num)

            for (let i = 0; i < 9; i++) {
                if (i !== col) {
                    board.value[row][i].notes = board.value[row][i].notes.filter(n => n !== num)
                }
            }

            for (let i = 0; i < 9; i++) {
                if (i !== row) {
                    board.value[i][col].notes = board.value[i][col].notes.filter(n => n !== num)
                }
            }

            const blockRow = Math.floor(row / 3) * 3
            const blockCol = Math.floor(col / 3) * 3
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    const r = blockRow + i
                    const c = blockCol + j
                    if (r !== row || c !== col) {
                        board.value[r][c].notes = board.value[r][c].notes.filter(n => n !== num)
                    }
                }
            }
        }

        const checkCellForError = (row, col) => {
            const cell = board.value[row][col]
            if (cell.value === 0 || cell.isFixed) {
                cell.isError = false
                return
            }

            cell.isError = !isValidMove(row, col, cell.value)
        }

        const checkAllCellsForErrors = () => {
            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    checkCellForError(row, col)
                }
            }
        }

        const canCompleteCurrentBoard = () => {
            const grid = board.value.map(row => row.map(cell => cell.value))

            const isValidInGrid = (row, col, num) => {
                for (let i = 0; i < 9; i++) {
                    if (i !== col && grid[row][i] === num) return false
                }

                for (let i = 0; i < 9; i++) {
                    if (i !== row && grid[i][col] === num) return false
                }

                const blockRow = Math.floor(row / 3) * 3
                const blockCol = Math.floor(col / 3) * 3

                for (let i = 0; i < 3; i++) {
                    for (let j = 0; j < 3; j++) {
                        const currentRow = blockRow + i
                        const currentCol = blockCol + j

                        if ((currentRow !== row || currentCol !== col) && grid[currentRow][currentCol] === num) {
                            return false
                        }
                    }
                }

                return true
            }

            const findBestEmptyCell = () => {
                let bestCell = null
                let bestCandidates = null

                for (let row = 0; row < 9; row++) {
                    for (let col = 0; col < 9; col++) {
                        if (grid[row][col] !== 0) continue

                        const candidates = []
                        for (let num = 1; num <= 9; num++) {
                            if (isValidInGrid(row, col, num)) {
                                candidates.push(num)
                            }
                        }

                        if (candidates.length === 0) {
                            return { row, col, candidates }
                        }

                        if (!bestCandidates || candidates.length < bestCandidates.length) {
                            bestCell = { row, col }
                            bestCandidates = candidates
                        }
                    }
                }

                if (!bestCell) return null

                return { ...bestCell, candidates: bestCandidates }
            }

            const solve = () => {
                const emptyCell = findBestEmptyCell()
                if (!emptyCell) return true
                if (emptyCell.candidates.length === 0) return false

                const { row, col, candidates } = emptyCell

                for (const num of candidates) {
                    grid[row][col] = num

                    if (solve()) {
                        return true
                    }

                    grid[row][col] = 0
                }

                return false
            }

            return solve()
        }

        const setNumber = (num) => {
            if (gameOver.value || hasWon.value) {
                return
            }

            if (!selectedCell.value) {
                message.value = 'Выберите ячейку'
                isError.value = true
                setTimeout(() => { message.value = '' }, 2000)
                return
            }

            const { row, col } = selectedCell.value
            const cell = board.value[row][col]

            if (cell.isFixed) {
                message.value = 'Нельзя изменять исходные числа'
                isError.value = true
                setTimeout(() => { message.value = '' }, 2000)
                return
            }

            if (noteMode.value) {
                const noteIndex = cell.notes.indexOf(num)
                if (noteIndex === -1) {
                    cell.notes.push(num)
                    cell.notes.sort((a, b) => a - b)
                } else {
                    cell.notes.splice(noteIndex, 1)
                }
            } else {
                saveHistorySnapshot()
                cell.value = num
                cell.notes = []

                removeNotesFromRelatedCells(row, col, num)
                checkAllCellsForErrors()

                const canComplete = canCompleteCurrentBoard()

                if (cell.isError || !canComplete) {
                    if (!cell.isError) {
                        cell.isError = true
                    }

                    mistakes.value += 1
                    isError.value = true

                    if (mistakes.value >= maxMistakes) {
                        gameOver.value = true
                        noteMode.value = false
                        message.value = !canComplete
                            ? 'Этот ход делает поле нерешаемым. Достигнут лимит в 3 ошибки.'
                            : 'Это неверная цифра. Достигнут лимит в 3 ошибки.'
                    } else {
                        message.value = !canComplete
                            ? `Этот ход делает поле нерешаемым. Ошибка ${mistakes.value} из ${maxMistakes}.`
                            : `Это неверная цифра. Ошибка ${mistakes.value} из ${maxMistakes}.`
                    }
                } else {
                    if (isBoardFilled()) {
                        triggerVictory()
                    } else {
                        message.value = ''
                        isError.value = false
                    }
                }
            }
        }

        const isValidMove = (row, col, num) => {
            for (let i = 0; i < 9; i++) {
                if (i !== col && board.value[row][i].value === num) return false
            }

            for (let i = 0; i < 9; i++) {
                if (i !== row && board.value[i][col].value === num) return false
            }

            const blockRow = Math.floor(row / 3) * 3
            const blockCol = Math.floor(col / 3) * 3
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    const r = blockRow + i
                    const c = blockCol + j
                    if ((r !== row || c !== col) && board.value[r][c].value === num) return false
                }
            }

            return true
        }

        const isAvailableInRowAndColumn = (row, col, num) => {
            for (let i = 0; i < 9; i++) {
                if (i !== col && board.value[row][i].value === num) return false
            }

            for (let i = 0; i < 9; i++) {
                if (i !== row && board.value[i][col].value === num) return false
            }

            const blockRow = Math.floor(row / 3) * 3
            const blockCol = Math.floor(col / 3) * 3

            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    const currentRow = blockRow + i
                    const currentCol = blockCol + j

                    if ((currentRow !== row || currentCol !== col) && board.value[currentRow][currentCol].value === num) {
                        return false
                    }
                }
            }

            return true
        }

        const clearCell = () => {
            if (gameOver.value || hasWon.value || !selectedCell.value) return

            const { row, col } = selectedCell.value
            const cell = board.value[row][col]

            if (!cell.isFixed && (cell.value !== 0 || cell.notes.length > 0)) {
                saveHistorySnapshot()
                cell.value = 0
                cell.notes = []
                cell.isError = false
                message.value = ''
                isError.value = false

                checkAllCellsForErrors()
            }
        }

        const toggleNoteMode = () => {
            if (gameOver.value || hasWon.value) return
            noteMode.value = !noteMode.value
        }

        const addNotesToAllEmpty = () => {
            if (gameOver.value || hasWon.value) return
            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    const cell = board.value[row][col]
                    if (cell.value === 0) {
                        const possibleNumbers = []
                        for (let num = 1; num <= 9; num++) {
                            if (isAvailableInRowAndColumn(row, col, num)) {
                                possibleNumbers.push(num)
                            }
                        }
                        cell.notes = possibleNumbers
                    }
                }
            }
            message.value = 'Заметки добавлены'
            isError.value = false
            setTimeout(() => { message.value = '' }, 2000)
        }

        const clearAllNotes = () => {
            if (gameOver.value || hasWon.value) return
            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    board.value[row][col].notes = []
                }
            }
            message.value = 'Заметки очищены'
            isError.value = false
            setTimeout(() => { message.value = '' }, 2000)
        }

        const undoLastMove = () => {
            const previousState = history.value.pop()
            if (!previousState) return

            board.value = previousState.board
            mistakes.value = previousState.mistakes
            gameOver.value = previousState.gameOver
            hasWon.value = previousState.hasWon
            selectedCell.value = previousState.selectedCell
            isError.value = false
            message.value = 'Последний ход отменен'
            checkAllCellsForErrors()
            setTimeout(() => { message.value = '' }, 2000)
        }

        const checkSolution = () => {
            if (gameOver.value) {
                message.value = 'Игра окончена. Начните новую игру.'
                isError.value = true
                return
            }

            if (hasWon.value) {
                message.value = 'Победа!'
                isError.value = false
                return
            }

            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    if (board.value[row][col].value === 0) {
                        message.value = 'Поле заполнено не полностью'
                        isError.value = true
                        return
                    }
                }
            }

            for (let row = 0; row < 9; row++) {
                for (let col = 0; col < 9; col++) {
                    const cell = board.value[row][col]
                    if (cell.isError) {
                        message.value = 'Найдены ошибки в решении'
                        isError.value = true
                        return
                    }
                }
            }

            triggerVictory()
        }

        return {
            board,
            selectedCell,
            noteMode,
            message,
            isError,
            difficulty,
            mistakes,
            maxMistakes,
            gameOver,
            hasWon,
            history,
            selectCell,
            isCellHighlighted,
            isSameValue,
            isNumberCompleted,
            setNumber,
            clearCell,
            toggleNoteMode,
            addNotesToAllEmpty,
            clearAllNotes,
            undoLastMove,
            generateNewGame,
            setDifficulty,
            checkSolution
        }
    }
}
</script>

<style scoped>
.sudoku-game {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

.game-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
    position: relative;
}

.sudoku-grid {
    border: 2px solid #333;
    display: inline-block;
    margin: 0 auto;
}

.sudoku-row {
    display: flex;
}

.sudoku-row.bottom-border {
    border-bottom: 2px solid #333;
}

.sudoku-cell {
    width: 50px;
    height: 50px;
    border: 1px solid #999;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    background-color: white;
    transition: all 0.2s ease;
}

.sudoku-cell.right-border {
    border-right: 2px solid #333;
}

.sudoku-cell.selected {
    background-color: #e3f2fd;
    border: 2px solid #2196f3;
}

.sudoku-cell.highlighted {
    background-color: #f5f5f5;
}

.sudoku-cell.fixed {
    background-color: #f0f0f0;
    font-weight: bold;
}

.sudoku-cell.error {
    background-color: #ffebee;
    border: 2px solid #f44336;
}

.sudoku-cell.same-value {
    background-color: #bbdefb;
}

.sudoku-cell.fixed.same-value {
    background-color: #90caf9;
}

.cell-value {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.sudoku-cell.error .cell-value {
    color: #c62828;
}

.sudoku-cell.same-value .cell-value {
    color: #0d47a1;
}

.notes-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(3, minmax(0, 1fr));
    gap: 2px;
    width: 100%;
    height: 100%;
    padding: 2px;
    box-sizing: border-box;
    overflow: hidden;
}

.note {
    font-size: 12px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: transparent;
    min-width: 0;
    min-height: 0;
}

.note.active {
    color: #2196f3;
    font-weight: bold;
}

.controls {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.number-pad {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: nowrap;
    overflow-x: auto;
    padding: 5px 0;
}

.number-btn {
    width: 45px;
    height: 45px;
    font-size: 20px;
    border: 1px solid #ccc;
    background-color: white;
    cursor: pointer;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.number-btn:hover:not(:disabled) {
    background-color: #f0f0f0;
    transform: scale(1.05);
}

.number-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.number-btn.completed-number {
    background-color: #e0e0e0;
    color: #666;
    border-color: #bdbdbd;
}

.clear-btn {
    background-color: #ffebee;
    color: #c62828;
    border-color: #ef9a9a;
}

.clear-btn:hover:not(:disabled) {
    background-color: #ffcdd2;
}

.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.action-buttons button {
    padding: 10px 15px;
    font-size: 14px;
    border: 1px solid #ccc;
    background-color: white;
    cursor: pointer;
    border-radius: 5px;
    min-width: 120px;
    transition: all 0.2s ease;
}

.action-buttons button:hover {
    background-color: #f0f0f0;
    transform: scale(1.02);
}

.action-buttons button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.action-buttons button.active {
    background-color: #2196f3;
    color: white;
    border-color: #1976d2;
}

.mistakes-counter {
    text-align: center;
    font-weight: bold;
    color: #c62828;
    background-color: #ffebee;
    border: 1px solid #ef9a9a;
    border-radius: 5px;
    padding: 10px;
}

.mistakes-counter.limit-reached {
    color: white;
    background-color: #c62828;
    border-color: #b71c1c;
}

.victory-overlay {
    position: absolute;
    inset: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.9);
    overflow: hidden;
    border-radius: 16px;
}

.victory-modal {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    padding: 28px 24px;
    border-radius: 16px;
    background: white;
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.16);
}

.victory-title {
    font-size: 34px;
    font-weight: 700;
    color: #2e7d32;
}

.victory-button {
    padding: 12px 20px;
    border: none;
    border-radius: 999px;
    background: #2e7d32;
    color: white;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
}

.fireworks {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.firework {
    position: absolute;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    opacity: 0;
    box-shadow:
        0 -34px 0 0 #ff7043,
        24px -24px 0 0 #42a5f5,
        34px 0 0 0 #ffee58,
        24px 24px 0 0 #ab47bc,
        0 34px 0 0 #66bb6a,
        -24px 24px 0 0 #ffa726,
        -34px 0 0 0 #ef5350,
        -24px -24px 0 0 #26c6da;
    animation: firework-burst 1.6s ease-out infinite;
}

.firework-a {
    top: 28%;
    left: 25%;
}

.firework-b {
    top: 22%;
    right: 24%;
    animation-delay: 0.35s;
}

.firework-c {
    bottom: 24%;
    left: 50%;
    animation-delay: 0.7s;
}

@keyframes firework-burst {
    0% {
        transform: scale(0.2);
        opacity: 0;
    }
    20% {
        opacity: 1;
    }
    100% {
        transform: scale(1.1);
        opacity: 0;
    }
}

.difficulty-selector {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 5px;
}

.difficulty-selector span {
    font-weight: bold;
    color: #333;
}

.difficulty-selector button {
    padding: 5px 15px;
    border: 1px solid #ccc;
    background-color: white;
    cursor: pointer;
    border-radius: 3px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.difficulty-selector button:hover {
    background-color: #e0e0e0;
}

.difficulty-selector button.active {
    background-color: #4caf50;
    color: white;
    border-color: #388e3c;
}

.keyboard-hint {
    text-align: center;
    padding: 8px;
    background-color: #e8f4fd;
    border-radius: 5px;
    color: #1976d2;
    font-size: 14px;
    border: 1px solid #bbdefb;
}

.message {
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.error {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid #ef9a9a;
}

.message:not(.error) {
    background-color: #e8f5e8;
    color: #2e7d32;
    border: 1px solid #a5d6a7;
}

/* Адаптивность для мобильных устройств */
@media (max-width: 600px) {
    .sudoku-cell {
        width: 35px;
        height: 35px;
    }

    .cell-value {
        font-size: 18px;
    }

    .note {
        font-size: 9px;
        line-height: 1;
    }

    .number-btn {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }

    .action-buttons button {
        min-width: 100px;
        font-size: 12px;
        padding: 8px 10px;
    }

    .difficulty-selector {
        flex-wrap: wrap;
    }

    .keyboard-hint {
        font-size: 12px;
        padding: 6px;
    }

    .victory-title {
        font-size: 28px;
    }
}

.cat-icon{ display: inline; max-height: 3rem; padding: 0 5px;}
.up_link{ color: #0d47a1; text-decoration: underline; }
</style>
