function fetchUsers() {
    fetch ('api/fetchUsers.php')
    .then(res=>res.json())
    .then(users=>{
      const userUL = document.querySelector('.users ul');
      userUL.innerHTML = '';
      users.forEach(user=>{
        const userLI = document.createElement ('LI');
        userLI.setAttribute ('data-uid', user.uid);
        userLI.innerHTML += `<span>${user.firstName} ${user.lastName}</span><span>${user.uname}</span>`;
        userUL.appendChild (userLI);
      })
      userUL.addEventListener('click', e=>{
        if (e.path[1].tagName=='LI') {
          editUser (e.path[1].dataset['uid']);
        } else if (e.target.tagName=='LI') {
          editUser (e.target.dataset['uid']);
        }
      })
    })
  }
  
  fetchUsers();
  