window.onload = listUsers;

const addIssueButton = document.getElementById("isub");

function listUsers(){
    const xhr = new XMLHttpRequest (); 
    const url = 'index.php?get=list'; //Url to server
    xhr.onreadystatechange = dosomething;
    function dosomething (){
        if (xhr.readyState === 4){
            if(xhr.status === 200){                
                var response = xhr.responseText;
                document.getElementById("users").innerHTML=response;
                console.log("php connect")
            }else{
                console.log("File not found");
                console.log("list user")
        }
    }
    }
    xhr.open('GET',url,true);
    xhr.send(); 
}


