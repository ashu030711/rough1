<head>
<script src="http://localhost/scripts/jquery.js"></script>
<style>
#totype{
 color:green;
}
#target{

}
</style>
</head>
<body>
<div id="wordtotype"></div>
<div id="totype"></div>
Type here
<input id="target" type="text" onfocus="this.value='';"  />
<div id="mismatch"></div>
<script	>

 //code to check a words taken from input.txt  
var wordin, wordtotype, fileString="", wordstyped; //main variables used    
var complete, mismatch;  //status variables
var fileWordsArray;
$.get("input2.txt",function(data) {
   fileString=data;
   wordtotype=getNewWord(); //PROBLEM this initialization
    fileWordsArray= fileString.split(' ');
	
   $("#totype").html(fileString);
   });
   
wordstyped=0;
complete=false;
mismatch=0;//measure of number of mismatches
$("#target").focus();//focus the element WHEN GAME STARTS, ONSTART  
/*************************MAIN CODE START FROM HERE*****************************************************/
 
    /*whenever a KEY IS PRESSED*/

$('#target').keypress(function(e){
	wordin=getValue();
	complete=checkWord(); //check the word till correct response is entered by user
	if(complete)
	{
	   $(this).val('');
	   wordcomplete();
	   e.preventDefault();//to remove the hanging space in starting
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

function checkWord()
{//checks the word till it is completed correctly by the user and then return true else return false
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
	{nowordmismatch();
	return false;//return false generally
    }
 }	 
function getNewWord()//called by wordcomplete function
{
	
	if(wordstyped == arr.length){
		console.log('last');
		return;
	}
   var str=arr[wordstyped++];
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
function wordmismatch()
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
}
</script>
</body>
