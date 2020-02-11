/*
GAME RULES:

- The game has 2 players, playing in rounds
- In each turn, a player rolls a dice as many times as he whishes. Each result get added to his ROUND score
- BUT, if the player rolls a 1, all his ROUND score gets lost. After that, it's the next player's turn
- The player can choose to 'Hold', which means that his ROUND score gets added to his GLBAL score. After that, it's the next player's turn
- The first player to reach 100 points on GLOBAL score wins the game

*/
/*
YOUR 3 CHALLENGES
Change the game to follow these rules:

1. A player looses his ENTIRE score when he rolls two 6 in a row.
After that, it's the next player's turn.
(Hint: Always save the previous dice roll in a separate variable)

2. Add an input field to the HTML where players can set the winning score,
so that they can change the predefined score of 100.
(Hint: you can read that value with the .value property in JavaScript.
This is a good oportunity to use google to figure this out :)

3. Add another dice to the game, so that there are two dices now.
The player looses his current score when one of them is a 1.
(Hint: you will need CSS to position the second dice,
so take a look at the CSS code for the first one.)
*/
var scores, roundscore, activePlayer, gamePlaying;

init();

var lastDice;

// var x = document.querySelector('#score-0').textContent;
// console.log(x);

// to change CSS ( to remove dice from the website changing CSS value to none):

document.querySelector('.dice').style.display = 'none';

// GET ELEMENTS by IDS instead of querySelector:

document.getElementById('score-0').textContent = '0';
document.getElementById('score-1').textContent = '0';
document.getElementById('current-0').textContent = '0';
document.getElementById('current-1').textContent = '0';


document.querySelector('.btn-roll').addEventListener('click', function(){
  if(gamePlaying){
    //Random number:
    var dice1 = Math.floor(Math.random() * 6) +1;
    var dice2 = Math.floor(Math.random() * 6) +1;

    //2. Display the result:
    document.getElementById('dice-1').style.display ='block';
    document.getElementById('dice-2').style.display ='block';
    document.getElementById('dice-1').src = 'dice-' + dice1 + '.png';
    document.getElementById('dice-2').src = 'dice-' + dice2 + '.png';

    // Update the round score.
    if (dice1!== 1 && dice2!== 1){

      roundScore += dice1 + dice2;

      document.querySelector('#current-' + activePlayer).textContent = roundScore;
    } else{
      nextPlayer();
    }

    /*if (dice === 6 && lastDice === 6){

      scores[activePlayer] = 0;
      document.querySelector('#score-' + activePlayer).textContent = 0;
      nextPlayer();
      //player loses score
    } else if (dice1 !== 1 && dice2 !==1){

      // add score
      roundScore += dice;
      document.querySelector('#current-' + activePlayer ).textContent = roundScore;
    } else{
      nextPlayer();
    }
    // lastDice = dice;*/
  }
});

// HOLD button:
document.querySelector('.btn-hold').addEventListener('click', function(){
  if(gamePlaying){
    // add current score to the global scores
    scores[activePlayer] += roundScore;

    // update the UI
    document.querySelector('#score-' + activePlayer).textContent = scores[activePlayer];

    //add input value:

    var input= document.querySelector('.final-score').value;

    var winningScore;
    //Undefined, 0, null, or "" or COERCED to falce
    //Anything else is COERSED to true
    if(input){
      var winningScore = input
    } else{
      winningScore = 100;
    }


    //check if player won a Game
    if (scores[activePlayer] >= winningScore){
      document.querySelector('#name-' + activePlayer).textContent = 'WINNER!';
      document.getElementById('dice-1').style.display ='none';
      document.getElementById('dice-2').style.display ='none';
      document.querySelector('.player-' + activePlayer + '-panel').classList.add('winner');
      document.querySelector('.player-' + activePlayer + '-panel').classList.remove('active');
      gamePlaying = false;
    } else{
      nextPlayer();
    }
  }
});

function nextPlayer(){
  activePlayer === 0 ? activePlayer = 1 : activePlayer = 0;
  roundScore = 0;
  document.getElementById('current-0').textContent = '0';
  document.getElementById('current-1').textContent = '0';
  // TOGGLE : to remove class if it's there or to remove it:
  document.querySelector('.player-0-panel').classList.toggle('active');
  document.querySelector('.player-1-panel').classList.toggle('active');

  document.getElementById('dice-1').style.display ='none';
  document.getElementById('dice-2').style.display ='none';
}


// Creating 'new game' button event:

document.querySelector('.btn-new').addEventListener('click', init);

function init(){
  scores = [0, 0];
  roundScore = 0;
  activePlayer = 0;
  gamePlaying = true;



  document.getElementById('dice-1').style.display ='none';
  document.getElementById('dice-2').style.display ='none';

  document.getElementById('score-0').textContent = '0';
  document.getElementById('score-1').textContent = '0';
  document.getElementById('current-0').textContent = '0';
  document.getElementById('current-1').textContent = '0';
  document.getElementById('name-0').textContent = 'Player 1';
  document.getElementById('name-1').textContent = 'Player 2';
    document.querySelector('.player-0-panel').classList.remove('winner');
    document.querySelector('.player-1-panel').classList.remove('winner');
    document.querySelector('.player-0-panel').classList.remove('active');
    document.querySelector('.player-1-panel').classList.remove('active');
    document.querySelector('.player-0-panel').classList.add('active');
}

init();
