notifyList = document.querySelector(".bellgg");
notifyBell = document.querySelector(".ti-bell");
recentActivity=document.querySelector(".recent-activity");




function isNumeric(num){
  return !isNaN(num)
}
currentNotificationNumber=0;

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "set_notification.php", true);
  xhr.onload = ()=>{
   
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(isNumeric(data))
          {
            if(parseInt(data)>currentNotificationNumber || currentNotificationNumber == 0)
            {
              notifyList.innerHTML = data;
              currentNotificationNumber = parseInt(data)
            }
          }
          else{
            notifyList.innerHTML = 0;
          }
          
           
        }
    }
  }
  xhr.send();
 
}, 2000);
  
  notifyList.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "update_notification.php", true);
    xhr.onload = ()=>{
     
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            notifyList.innerHTML = 0;
            currentNotificationNumber=0;
             // var data_array = $.parseJSON(xhr.response);
             // console.log(xhr.response);
              recentActivity.innerHTML = xhr.response

              
          }
      }
    }
    xhr.send();
}

notifyBell.onclick = ()=>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "update_notification.php", true);
  xhr.onload = ()=>{
   
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          notifyList.innerHTML = 0;
           // var data_array = $.parseJSON(xhr.response);
           // console.log(xhr.response);
            recentActivity.innerHTML = xhr.response
        }
    }
  }
  xhr.send();
}