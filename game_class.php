<?php

Class Game {

    public $player; // current player
    public $board; // tic tac toe board 3*3
    public $game_moves; // total moves on board
    public $game_over; // detect game over
    public $winner; // store who is the winner
   
    public function __construct() {
      
        // empty board array
        $this->board = array();

       // x will play if no players
       $this->player = "X";
       
       // total 9 moves on the board
        $this->game_moves = 9;

        // game still on
        $this->game_over = false;

        // no winner yet
        $this->winner = false;
        
        // iniliaze the board 3*3 empty matrix
        $this->ini_board();
    }

    /**
	* Description: Intialize the Board
	* Preconditions: none
	* Postconditions: store the board array into board proprety 
	**/
    public function ini_board(){
        
        // iniliaze the board 3*3 empty matrix
        for ($x = 0; $x <= 2; $x++)
        {
            for ($y = 0; $y <= 2; $y++)
            {
                $this->board[$x][$y] = false;
            }
        }
    }

     /**
	* Description: update the inilized board by the posted player new value
	* Preconditions: the posted value on board
    * Postconditions: 
    *   return if board posted is empty 
    *   return and destroy the session to start new game after checking game over 
    *   update the board proprety with the new posted value 
    *   Switch the player form x to O or VRS
	**/
    public function move_board($post_board){
       
        // check empty board posted value
        if(!isset($post_board["board"])){
            return;
        }
        
        // check if the game over
        if ($this->is_end()){

            if(!$this->winner){
             $this->winner = $this->player;
            }

            session_destroy();
            return;
        }
 
        
        // get the position the posted value on board matrix
        $exp = explode("_", $post_board["board"]);
        $this->board[$exp[1]][$exp[3]] = $this->player;
        
        // Switch players
        if ($this->player == "X"){
            $this->player = "O";
        }
        else{
            $this->player = "X";
        }
           
        // decrease game moves to check Tie Situation
        $this->game_moves--;


        // check game over after updating the board 
        if ($this->is_end()){
            
            if(!$this->winner){
            $this->winner = $this->player;
            }
            
            session_destroy();
            return;
        }
        
        
    }

    
      /**
	* Description: Check the winning situation
	* Preconditions: updated board values
    * Postconditions: 
    *   return true if game over 
    *   store winner player to winner property even if it is a tie
	**/
    public function is_end(){
    
        $game_over = false;

        // first  row win
        if( $this->board[0][0] && ($this->board[0][0] == $this->board[0][1]) && ($this->board[0][0] == $this->board[0][2] )){
            $game_over = true;
            $this->winner = $this->board[0][0] ;
        }
        // second  row win
        if($this->board[1][0] &&  ($this->board[1][0] == $this->board[1][1]) && ($this->board[1][0] == $this->board[1][2] )){
            $game_over = true;
            $this->winner = $this->board[1][0] ;
         }
          // third  row win
         if($this->board[2][0] &&  ($this->board[2][0] == $this->board[2][1]) && ($this->board[2][0] == $this->board[2][2] )){
            $game_over = true;
            $this->winner = $this->board[2][0] ;
         }

           // left: first  column  win
         if($this->board[0][0] && ($this->board[0][0] == $this->board[1][0]) && ($this->board[0][0] == $this->board[2][0] )){
            $game_over = true;
            $this->winner = $this->board[0][0] ;
         }
           // left: second  column  win
         if($this->board[0][1] &&  ($this->board[0][1] == $this->board[1][1]) && ($this->board[0][1] == $this->board[2][1] )){
            $game_over = true;
            $this->winner = $this->board[0][1] ;
         }
         // left: third  column  win
         if($this->board[0][2] &&  ($this->board[0][2] == $this->board[1][2]) && ($this->board[0][2] == $this->board[2][2] )){
            $game_over = true;
            $this->winner = $this->board[0][2] ;
         }

         //Diagonal one
         if($this->board[0][0] &&  ($this->board[0][0] == $this->board[1][1]) && ($this->board[1][1] == $this->board[2][2] )){
            $game_over = true;
            $this->winner = $this->board[0][0] ;
         }
          //Diagonal two
         if($this->board[0][2] &&  ($this->board[0][2] == $this->board[1][1]) && ($this->board[1][1] == $this->board[2][0] )){
            $game_over = true;
            $this->winner = $this->board[0][2] ;
         }

         // Tie if no more moves
        if ($this->game_moves <= 0){
            $this->winner = "Tie";
            $game_over = true;
         }
            
        $this->game_over = $game_over;
        return $game_over;
    }



      /**
	* Description: Displying HTML Game : ( radio buttons for matrix / submit button for switching players / who is the current player ) 
	* Preconditions: updated board values stored in property
    * Postconditions: displaying game to user
	**/
    public function display_board(){
       
        echo "<table class='board'>";
			
			for ($x = 0; $x < 3; $x++)
			{
                echo "<tr class='board_row'>";
				for ($y = 0; $y < 3; $y++)
				{

					echo "<td class='board_cell'>";
					
					//check to see if that position is already filled
					if ($this->board[$x][$y])
                        echo "<label class='label_text'>".$this->board[$x][$y]."</label>";
					else
					{
                        echo "<input type='radio' name='board' value='t_".$x."_t_".$y."'>";
                        echo "<label class='label_text'>".$this->board[$x][$y]."</label>";
						
					}
					
					echo "</td>";
                }
                echo "</tr>";
			}
			
            echo "<tr>
            <td colspan='3'> <input type='submit' name='done' value='Done' class='submit'/> </td>
            </tr>";

            echo "<tr>
            <td colspan='3'> <p>Player ".$this->player." 's Turn </p> </td>
            </tr>";
				
            echo "</table>";
            
    }


}



