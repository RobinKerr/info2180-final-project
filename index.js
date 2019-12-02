function validate()
{
    
    var pass = document.getElementById("pass").value;
    var email = document.getElementById("mail").value;
    if(validatePassword(pass) && validateEmail(email))
    {
        alert("good info");
    return true;
    }
        
}
    
        
  

function validatePassword(inputText)
{
    var passwordMatch = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if(inputText.match(passwordMatch)){
        return true;
    }
    else
    {
        alert("not good password");
        return false;
    }
} 

function validateEmail(inputText)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(inputText.match(mailformat))
    {
        return true;
    }else
    {
        alert("Not good email");
        return false;
    }
}