<?php

// Game Class
require('game_class.php');

// start the session to store the game values when refreshing the page
session_start();

// check if no sessions / new game
if (!isset($_SESSION['game']))
    $_SESSION['game'] = new Game();

// check post .. detecting a move in the game
if($_POST){
    // applay the move on board
    $_SESSION['game']->move_board($_POST);
}
?>

<html>
	<head>
		<title>Tic Tac Toe</title>
        <style>
             /* Styling the Table to look nice */
            #content{
                text-align:center;
            }
            .board , tr , td{
                border: 1px solid black;
                margin: 0 auto;
            }
            tr , td{
                width:80px;
                height:80px;
            }
            .board{
                width:200px;
               
                text-align:center;
            }
            .submit{
                width:100%;
                height:100%;
                
            } 
            
        </style>
	</head>
	<body>
		<div id="content">
            <?php if($_SESSION['game']->game_over == false){ ?>
                    <!-- Game still running -->
		            <form action="index.php" method="POST">
                          <h1>Tic Tac Toe!</h1>
                          <?php $_SESSION['game']->display_board();  ?>
		            </form>
            <?php } else { ?>
                    <!-- Game Over -->
                    <p>
                        Game Over <br>
                        Game Winner : <?php echo  $_SESSION['game']->winner; ?>
                        <a href="index.php"> Play Again </a>
                    </p>
              <?php } ?>

		</div>
	</body>
</html>

