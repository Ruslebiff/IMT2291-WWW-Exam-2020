window.uid = -1;
function editUser(uid) {
  fetch(`api/fetchUser.php?id=${uid}`)
  .then(res=>res.json())
  .then(user=>{
    window.uid = user.uid;

    // Add existing values to form:
    document.getElementById('uname').value = user.uname;
    document.getElementById('firstName').value = user.firstName;
    document.getElementById('lastName').value = user.lastName;
  })
}

// Update user in DB with form data
document.querySelector('input[type="submit"]').addEventListener('click', e=>{
  e.preventDefault();
  
  if (window.uid>-1) {
    const data = new FormData(e.target.form);
    data.append('uid', window.uid);
    fetch('api/updateUser.php', {
      method: 'POST',
      body: data
    }).then(res=>res.json())
      .then(data=>{
        const response = document.querySelector('.response');
        response.style.display = 'block';
        
        if (data.status=='success') {
          response.style.color = "#0B0";
          response.innerHTML = "Informasjon om brukeren er oppdatert";
          fetchUsers();
        } else {
          response.style.color = "#F00";
          response.innerHTML = "Error: " + data.msg;
          console.log(data.msg);
        }
      })
  }
})
