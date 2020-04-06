/** Function that triggers a callback function if the user enters the Konami Code */
function konami(callback: () => void) {
    const arr = new Array(10);
    const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];
    document.addEventListener('keydown', event => {
        if (arr.length >= 10) arr.shift();
        arr.push(event.code);
        if (arr.length === 10 && arr.every((val, i) => val === konamiCode[i])) callback();
    });
}

konami(generateTetris);

function generateTetris() {
    if ((<any> window).tetris) return;
    (<any> window).tetris = true;

    const container: HTMLDivElement = document.createElement('div');
    container.id = 'tetris';
    const score: HTMLParagraphElement = document.createElement('p');
    const close: HTMLDivElement = document.createElement('div');
    close.classList.add('close');
    close.addEventListener('click', () => {
        document.body.removeChild(container);
        (<any> window).tetris = false;
    });
    const style: HTMLStyleElement = document.createElement('style');
    style.innerHTML = '#tetris{background:#fff;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);padding:14pt;border-radius:5pt;box-shadow:0 0 5px red;animation:rainbow 5s linear infinite}#tetris p{text-align:center;font-weight:700;margin:0 0 5pt}#tetris p::before{content:"Score: ";font-weight:400}#tetris .close{position:absolute;top:2pt;right:2pt;cursor:pointer}#tetris .close::before{content:"\\e90a";color:#777;font-size:14pt;font-style:normal;font-variant:normal;font-weight:400;font-family:icomoon!important;line-height:1;speak:none;text-transform:none;vertical-align:middle}@keyframes rainbow{0%,100%{box-shadow:0 0 5pt red}14.2%{box-shadow:0 0 5pt orange}28.5%{box-shadow:0 0 5pt #ff0}42.9%{box-shadow:0 0 5pt green}57.1%{box-shadow:0 0 5pt #00f}71.4%{box-shadow:0 0 5pt indigo}85.7%{box-shadow:0 0 5pt violet}}';
    const canvas: HTMLCanvasElement = document.createElement('canvas');
    [canvas.width, canvas.height] = [240, 400];
    const context: CanvasRenderingContext2D = canvas.getContext('2d') as CanvasRenderingContext2D;
    context.scale(20, 20);

    const arena = createMatrix(12, 20);
    const colors = [null, '#ff0d72', '#0dc2ff', '#0dff72', '#f528ff', '#ff8e0d', '#ffe138', '#3877ff'];
    const player: Player = {
        pos: {x: 0, y: 0},
        matrix: null,
        score: 0
    };

    document.addEventListener('keydown', event => {
        switch(event.code) {
            case 'ArrowLeft':
            case 'KeyA':
                playerMove(-1);
                break;
            case 'ArrowRight':
            case 'KeyD':
                playerMove(1);
                break;
            case 'ArrowDown':
            case 'KeyS':
                playerDrop();
                break;
            case 'KeyQ':
                playerRotate(-1);
                break;
            case 'KeyE':
                playerRotate(1);
                break;
        }
    });

    playerReset();
    updateScore();
    update();

    appendToContainer(score, close, style, canvas);
    document.body.appendChild(container);

    function appendToContainer(...elements: HTMLElement[]) {
        for (let element of elements) container.appendChild(element);
    }

    function arenaSweep() {
        let rowCount = 1;
        outer: for (let y = arena.length - 1; y > 0; --y) {
            for (let x = 0; x < arena[y].length; ++x) {
                if (arena[y][x] === 0) continue outer;
            }

            const row = arena.splice(y, 1)[0].fill(0);
            arena.unshift(row);
            ++y;

            player.score += rowCount * 10;
            rowCount *= 2;
        }
    }

    function collide(arena: Matrix, player: Player) {
        const [m, o] = [player.matrix as Matrix, player.pos];
        for (let y = 0; y < m.length; ++y) {
            for (let x = 0; x < m[y].length; ++x) {
                if (m[y][x] !== 0 && (arena[y + o.y] && arena[y + o.y][x + o.x]) !== 0) {
                    return true;
                }
            }
        }
        return false;
    }

    function createMatrix(w: number, h: number) {
        const matrix = [];
        while (h--) {
            matrix.push(new Array(w).fill(0));
        }
        return matrix;
    }

    function createPiece(type: PieceType) {
        switch (type) {
            case 'T':
                return [
                    [1, 1, 1],
                    [0, 1, 0],
                    [0, 0, 0]
                ];
            case 'O':
                return [
                    [2, 2],
                    [2, 2]
                ];
            case 'L':
                return [
                    [0, 3, 0],
                    [0, 3, 0],
                    [0, 3, 3]
                ];
            case 'J':
                return [
                    [0, 4, 0],
                    [0, 4, 0],
                    [4, 4, 0]
                ];
            case 'I':
                return [
                    [0, 5, 0, 0],
                    [0, 5, 0, 0],
                    [0, 5, 0, 0],
                    [0, 5, 0, 0]
                ];
            case 'S':
                return [
                    [0, 6, 6],
                    [6, 6, 0],
                    [0, 0, 0]
                ];
            case 'Z':
                return [
                    [7, 7, 0],
                    [0, 7, 7],
                    [0, 0, 0]
                ];
        }
    }

    function draw() {
        context.fillStyle = '#000';
        context.fillRect(0, 0, canvas.width, canvas.height);
        drawMatrix(arena, {x: 0, y: 0});
        drawMatrix(player.matrix as Matrix, player.pos);
    }

    function drawMatrix(matrix: Matrix, offset: GamePosition) {
        matrix.forEach((row, y) => {
            row.forEach((value, x) => {
                if (value !== 0) {
                    context.fillStyle = colors[value] as string;
                    context.fillRect(x+ offset.x, y + offset.y, 1, 1);
                }
            });
        });
    }

    function merge(arena: Matrix, player: Player) {
        (player.matrix as Matrix).forEach((row, y) => {
           row.forEach((value, x) => {
               if (value !== 0) {
                   arena[y + player.pos.y][x + player.pos.x] = value;
               }
           });
        });
    }

    function playerDrop() {
        player.pos.y++;
        if (collide(arena, player)) {
            player.pos.y--;
            merge(arena, player);
            playerReset();
            arenaSweep();
            updateScore();
        }
        dropCounter = 0;
    }

    function playerMove(dir: -1|1) {
        player.pos.x += dir;
        if (collide(arena, player)) {
            player.pos.x -= dir;
        }
    }

    function playerReset() {
        const pieces = 'ILJOTSZ';
        player.matrix = createPiece(pieces[pieces.length * Math.random() | 0] as PieceType);
        player.pos.y = 0;
        player.pos.x = (arena[0].length / 2 | 0) - ((<Matrix> player.matrix)[0].length / 2 | 0);
        if (collide(arena, player)) {
            arena.forEach(row => row.fill(0));
            player.score = 0;
            updateScore();
        }
    }

    function playerRotate(dir: number) {
        const pos = player.pos.x;
        let offset = 1;
        rotate(<Matrix> player.matrix, dir);
        while (collide(arena, player)) {
            player.pos.x += offset;
            offset = -(offset + (offset > 0 ? 1 : -1));
            if (offset > (<Matrix> player.matrix)[0].length) {
                rotate(<Matrix> player.matrix, -dir);
                player.pos.x = pos;
                return;
            }
        }
    }

    function rotate(matrix: Matrix, dir: number) {
        for (let y = 0; y < matrix.length; ++y) {
            for (let x = 0; x < y; ++x) {
                [
                    matrix[x][y],
                    matrix[y][x]
                ] = [
                    matrix[y][x],
                    matrix[x][y]
                ]
            }
        }

        if (dir > 0) {
            matrix.forEach(row => row.reverse());
        } else {
            matrix.reverse();
        }
    }

    let dropCounter = 0;
    let dropInterval = 1000;

    let lastTime = 0;
    function update(time = 0) {
        const deltaTime = time - lastTime;
        lastTime = time;

        dropCounter += deltaTime;
        if (dropCounter > dropInterval) {
            playerDrop();
        }

        draw();
        requestAnimationFrame(update);
    }

    function updateScore() {
        score.innerText = player.score.toString();
    }
}

type Matrix = number[][];
type PieceType = 'T'|'O'|'L'|'J'|'I'|'S'|'Z';
interface GamePosition {x: number, y: number}
interface Player {
    pos: GamePosition,
    matrix: Matrix|null,
    score: number
}