

	<head>

		<link rel="stylesheet" type="text/css" href='/public/scripts/main/game/css/pacman.css'/>
		<link rel="stylesheet" type="text/css" href='/public/scripts/main/game/css/pacman-home.css' />

		<script type="text/javascript" src="/public/scripts/main/game/js/jquery.js"></script>
		<!--<script type="text/javascript" src="js/jquery-mobile.js"></script>-->
		<script type="text/javascript" src="/public/scripts/main/game/js/jquery-buzz.js"></script>

		<script type="text/javascript" src="/public/scripts/main/game/js/game.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/tools.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/board.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/paths.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/bubbles.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/fruits.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/pacman.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/ghosts.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/home.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/sound.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game/js/sound.js"></script>
		<script type="text/javascript" src="/public/scripts/main/game.js"></script>
        </head>
        <div class='main_left_menu'>
        	<div class="hello_user" onclick='qwer()'>Привет&nbsp;&nbsp;&nbsp;<a href='#'><b><?=$_COOKIE['login'] ?? 'Гость';?></a></b></div>
        	<div class='public_room_list'>
        	</div>
        	<div class='private_room_list'>
        	</div>
        	<div class='friend_list'>
        	</div>
        </div>

        <div class='main_box' id='main_box'>
            <div class=game_pacman><div class=game>

            <div id="sound"></div>

            <div id="home">
                <canvas id="canvas-home-title-pacman"></canvas>
                <div id="presentation">
                    <div id="presentation-titles">character &nbsp;/&nbsp; nickname</div>
                    <canvas id="canvas-presentation-blinky"></canvas><div id="presentation-character-blinky">- shadow</div><div id="presentation-name-blinky">"blinky"</div>
                    <canvas id="canvas-presentation-pinky"></canvas><div id="presentation-character-pinky">- speedy</div><div id="presentation-name-pinky">"pinky"</div>
                    <canvas id="canvas-presentation-inky"></canvas><div id="presentation-character-inky">- bashful</div><div id="presentation-name-inky">"inky"</div>
                    <canvas id="canvas-presentation-clyde"></canvas><div id="presentation-character-clyde">- pokey</div><div id="presentation-name-clyde">"clyde"</div>
                </div>
                <canvas id="trailer"></canvas>
                <a class="sound" href="javascript:void(0);" data-sound="on"><img src="/public/scripts/main/game/img/sound-on.png" alt="" border="0"></a>
            </div>

            <div id="panel">
                <canvas id="canvas-panel-title-pacman"></canvas>
                <div id="score"><h2>1UP</h2><span>00</span></div>
                <div id="highscore"><h2>Score</h2><span>00</span></div>
                <div id="board">
                    <canvas id="canvas-board"></canvas>
                    <canvas id="canvas-paths"></canvas>
                    <canvas id="canvas-bubbles"></canvas>
                    <canvas id="canvas-fruits"></canvas>
                    <canvas id="canvas-pacman"></canvas>
                    <canvas id="canvas-ghost-blinky"></canvas>
                    <canvas id="canvas-ghost-pinky"></canvas>
                    <canvas id="canvas-ghost-inky"></canvas>
                    <canvas id="canvas-ghost-clyde"></canvas>
                    <div id="control-up-big"></div>
                    <div id="control-down-big"></div>
                    <div id="control-left-big"></div>
                    <div id="control-right-big"></div>
                </div>
                <div id="control">
                    <div id="control-up"></div>
                    <div id="control-up-second"></div>
                    <div id="control-down"></div>
                    <div id="control-down-second"></div>
                    <div id="control-left"></div>
                    <div id="control-right"></div>
                </div>
                <canvas id="canvas-lifes"></canvas>
                <canvas id="canvas-level-fruits"></canvas>
                <div id="message"></div>
                <a class="sound" href="javascript:void(0);" data-sound="on"><img src="/public/scripts/main/game/img/sound-on.png" alt="" border="0"></a>
            </div>

            </div>
</div>
        	<li id='error_message'></li>
        	<div class='message_box_game' id='message_box'></div>
        	<div class='send_message'>
        		<textarea class='user_send_message' name='send_message'></textarea>
        		<input class='button_send_message' type=button>
        	</div>
        </div>
