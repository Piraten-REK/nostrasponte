/** Function that triggers a callback function if the user enters the Konami Code */
function konami(callback) {
    var arr = new Array(10);
    var konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];
    document.addEventListener('keydown', function (event) {
        if (arr.length >= 10)
            arr.shift();
        arr.push(event.code);
        if (arr.length === 10 && arr.every(function (val, i) { return val === konamiCode[i]; }))
            callback();
    });
}
konami(generateTetris);
function generateTetris() {
    var _a;
    if (window.tetris)
        return;
    window.tetris = true;
    var container = document.createElement('div');
    container.id = 'tetris';
    var score = document.createElement('p');
    var close = document.createElement('div');
    close.classList.add('close');
    close.addEventListener('click', function () {
        document.body.removeChild(container);
        window.tetris = false;
    });
    var style = document.createElement('style');
    style.innerHTML = '#tetris{background:#fff;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);padding:14pt;border-radius:5pt;box-shadow:0 0 5px red;animation:rainbow 5s linear infinite}#tetris p{text-align:center;font-weight:700;margin:0 0 5pt}#tetris p::before{content:"Score: ";font-weight:400}#tetris .close{position:absolute;top:2pt;right:2pt;cursor:pointer}#tetris .close::before{content:"\\e90a";color:#777;font-size:14pt;font-style:normal;font-variant:normal;font-weight:400;font-family:icomoon!important;line-height:1;speak:none;text-transform:none;vertical-align:middle}@keyframes rainbow{0%,100%{box-shadow:0 0 5pt red}14.2%{box-shadow:0 0 5pt orange}28.5%{box-shadow:0 0 5pt #ff0}42.9%{box-shadow:0 0 5pt green}57.1%{box-shadow:0 0 5pt #00f}71.4%{box-shadow:0 0 5pt indigo}85.7%{box-shadow:0 0 5pt violet}}';
    var canvas = document.createElement('canvas');
    _a = [240, 400], canvas.width = _a[0], canvas.height = _a[1];
    var context = canvas.getContext('2d');
    context.scale(20, 20);
    var arena = createMatrix(12, 20);
    var colors = [null, '#ff0d72', '#0dc2ff', '#0dff72', '#f528ff', '#ff8e0d', '#ffe138', '#3877ff'];
    var player = {
        pos: { x: 0, y: 0 },
        matrix: null,
        score: 0
    };
    document.addEventListener('keydown', function (event) {
        switch (event.code) {
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
    function appendToContainer() {
        var elements = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            elements[_i] = arguments[_i];
        }
        for (var _a = 0, elements_1 = elements; _a < elements_1.length; _a++) {
            var element = elements_1[_a];
            container.appendChild(element);
        }
    }
    function arenaSweep() {
        var rowCount = 1;
        outer: for (var y = arena.length - 1; y > 0; --y) {
            for (var x = 0; x < arena[y].length; ++x) {
                if (arena[y][x] === 0)
                    continue outer;
            }
            var row = arena.splice(y, 1)[0].fill(0);
            arena.unshift(row);
            ++y;
            player.score += rowCount * 10;
            rowCount *= 2;
        }
    }
    function collide(arena, player) {
        var _a = [player.matrix, player.pos], m = _a[0], o = _a[1];
        for (var y = 0; y < m.length; ++y) {
            for (var x = 0; x < m[y].length; ++x) {
                if (m[y][x] !== 0 && (arena[y + o.y] && arena[y + o.y][x + o.x]) !== 0) {
                    return true;
                }
            }
        }
        return false;
    }
    function createMatrix(w, h) {
        var matrix = [];
        while (h--) {
            matrix.push(new Array(w).fill(0));
        }
        return matrix;
    }
    function createPiece(type) {
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
        drawMatrix(arena, { x: 0, y: 0 });
        drawMatrix(player.matrix, player.pos);
    }
    function drawMatrix(matrix, offset) {
        matrix.forEach(function (row, y) {
            row.forEach(function (value, x) {
                if (value !== 0) {
                    context.fillStyle = colors[value];
                    context.fillRect(x + offset.x, y + offset.y, 1, 1);
                }
            });
        });
    }
    function merge(arena, player) {
        player.matrix.forEach(function (row, y) {
            row.forEach(function (value, x) {
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
    function playerMove(dir) {
        player.pos.x += dir;
        if (collide(arena, player)) {
            player.pos.x -= dir;
        }
    }
    function playerReset() {
        var pieces = 'ILJOTSZ';
        player.matrix = createPiece(pieces[pieces.length * Math.random() | 0]);
        player.pos.y = 0;
        player.pos.x = (arena[0].length / 2 | 0) - (player.matrix[0].length / 2 | 0);
        if (collide(arena, player)) {
            arena.forEach(function (row) { return row.fill(0); });
            player.score = 0;
            updateScore();
        }
    }
    function playerRotate(dir) {
        var pos = player.pos.x;
        var offset = 1;
        rotate(player.matrix, dir);
        while (collide(arena, player)) {
            player.pos.x += offset;
            offset = -(offset + (offset > 0 ? 1 : -1));
            if (offset > player.matrix[0].length) {
                rotate(player.matrix, -dir);
                player.pos.x = pos;
                return;
            }
        }
    }
    function rotate(matrix, dir) {
        var _a;
        for (var y = 0; y < matrix.length; ++y) {
            for (var x = 0; x < y; ++x) {
                _a = [
                    matrix[y][x],
                    matrix[x][y]
                ], matrix[x][y] = _a[0], matrix[y][x] = _a[1];
            }
        }
        if (dir > 0) {
            matrix.forEach(function (row) { return row.reverse(); });
        }
        else {
            matrix.reverse();
        }
    }
    var dropCounter = 0;
    var dropInterval = 1000;
    var lastTime = 0;
    function update(time) {
        if (time === void 0) { time = 0; }
        var deltaTime = time - lastTime;
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
