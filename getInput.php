<head>
<script src="http://localhost/scripts/jquery.js"></script>
<style>
#wordstotype{
 color:green;
}
#target{

}
</style>
</head>
<body>
<div id="wordstotype_container">
<div id="wordstotype"></div>

Type here <input id="target"  type="text" onfocus="this.value='';" disabled="disabled"  />
</div>
<div id="mismatch"></div>
<div id="type_speed"></div>
<script	>

 //code to check a words taken from input.txt  
var wordin, wordtotype, fileString="", wordstyped; //main variables used    
var complete, mismatch;
var gameOver, gameStartTime, gameTotalTime, gameKeyStrokes;  //game overall status variables
var instKeyStrokes, instTime; //instantaneous valriables reevaluated at each keypress
$(document).ready(function () {
    GameStart();
});

function GameStart()
{
$.get("input2.txt",function(data) {
   fileString=data;
   wordtotype=getNewWord(); //PROBLEM this initialization
   fileWordsArray=fileString.split(' ');
   $("#wordstotype").html(fileString);
});
gameKeyStrokes=instKeyStrokes=0;
gameOver=false;   
gameStartTime=new Date();  //current time when statement executed
instTime=0; //time since start of the game
wordstyped=0;
complete=false;
mismatch=0;//measure of number of mismatches

/*----------------------------MAIN CODE START FROM HERE-----------------------------------------*/
   /*Initial values*/

$("#target").removeAttr("disabled");
$("#target").focus();//focus the element after enable by removing disabled property --IMPORTANT  
     
    /*whenever a KEY IS PRESSED*/
}
$('#target').keypress(function(e){
	wordin=getValue();
	
	if(!gameOver)
	{
	   complete=checkWord(); //check the word till correct response is entered by user
	   if(complete)
	   {
	      $(this).val('');
	      wordcomplete();
	      if(gameOver)
		  {
		     functionGameOver();  
	      }
		  e.preventDefault();//to remove the hanging space in starting
       }
	}
    else
    if(gameOver)//redundant code
    {
	   functionGameOver();
	}	
});
	 
	 /*Fucntions*/
  function getValue()
  {
  //keypress or even change event, .val() does not contain the most recent key pressed unless followed by another key
     wordin=$('#target').val()+String.fromCharCode(event.which);
	 //console.log('changed text in keypress:  '+wordin);   
     return wordin;
  }//end of getvalue()

  function checkWord()//checks the word input by user is correct or not called by $("#target").keypress
  {
    //checks the word till it is completed correctly by the user and then return true else return false
    //check if the wordinput by the user is same as word to type
    
	for (var i=0, lentyped=wordin.length; i<lentyped; i++) {
       if(wordin.charAt(i) == wordtotype.charAt(i))
	      continue;
	   else
	   if(i == wordtotype.length && wordtotype.length==wordin.length-1)//string is complete must end with a space or enter now
	   {   if(wordin.charAt(i)==' ' || wordin.charCodeAt(i) == 13)
		    { 
     		  return true;//word complete 
			  continue;
			}   
	   }
	   else
	   {
	   wordmismatch();
       return false;//words mismatched	   
	   }
	}//end of for-loop
	if(lentyped == i)
	{
	   instKeyStrokes=gameKeyStrokes+lentyped;
	   instTime=(new Date().getTime())-gameStartTime.getTime();
	   $("#type_speed").html(instKeyStrokes*60*1000/instTime/5);
	   console.log("time "+instKeyStrokes+" "+instTime);
	   nowordmismatch();
	   return false;//return false generally
    }
  }	 
  function getNewWord()//called by wordcomplete function to get a new word and increment the wordstyped(number) by one
  {
	var fileWordsArray=fileString.split(' ');
	if(wordstyped == fileWordsArray.length){
		console.log('last');//game over
		gameOver=true;
		return;
	}
	
    var str=fileWordsArray[wordstyped++];
    //remove leading spaces or enter
    if(str=="")
    { 
       console.log('String blank');
    }
    var j=0; 
    var c;
    // console.log('characters');
    while( (c=str.charAt(j)) == ' ' || c =='\n'|| str.charCodeAt(j)==13)
	{
		j++;
	    console.log(c);
	}
	str=str.substring(j, str.length);			
	
	//console.log(j+'\n'+str);   
    return str ;
  }
  function wordmismatch()/*action to be taken on word mismatch of input by user wordin and wordtotype*/
  {
     mismatch++;
     if(mismatch > 2)
     $("#mismatch").html("Typo alert! you are supposed to type the word <span style='color:red'>"+wordtotype+"</span> and then space");
     console.log('mismatch');
     $("#target").css("background-color","yellow");
  }
  function nowordmismatch()
  {
     mismatch=0;
     $("#mismatch").html("");
     $("#target").css("background-color","white");
  }
  function wordcomplete() //called by $(keypress) if(complete)
  {
     //  console.log("complete "+complete);
     var t = $('#target');
     t.val('');
     wordin="";
     wordtotype=getNewWord();
     t.focus();
	 gameKeyStrokes = instKeyStrokes;
  }
  function functionGameOver()
  {
     //Initialise or change variables
	 gameTotalTime=((new Date).getTime())-gameStartTime.getTime();
	 console.log(gameTotalTime);
	 //Chane page content
     $("#target").attr("disabled", true);//do not make it "disabled" as in a normal DOM element as was <input disabled="disabled" />
     $("#target").css('display', 'hidden');	//NOT WORKING  
	 $("#target").hide(); //TO BE USED INSTEAD OF THE NOT WORKING
	 $('#target').blur();
	 console.log('inside functionGameOver');
	 $("#wordstotype_container").html("Your time was:"+gameTotalTime+"milliseconds");
	 $("#type_speed").html(gameKeyStrokes+ "keys at" + gameKeyStrokes*1000 / gameTotalTime +" = "+gameKeyStrokes*60*1000/gameTotalTime/4.9);
	 }
  function gameSpeed()
  {
     return instKeyStroke*1000/gameTotalTime;
  }
</script>
</body>
