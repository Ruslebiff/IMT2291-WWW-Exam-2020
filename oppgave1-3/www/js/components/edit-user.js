import { LitElement, html, css } from "../../node_modules/lit-element/lit-element.js";

class EditUser extends LitElement {
  static get properties() {
    return {
      user: { type: Object }
    };
  }


      /**
     * Instance of the element is created/upgraded. Use: initializing state,
     * set up event listeners, create shadow dom.
     * @constructor
     */
    constructor() {
      super();
  }

  editUser(uid) {
    fetch(`api/fetchUser.php?id=${uid}`)
    .then(res=>res.json())
    .then(user=>{
      window.uid = user.uid;
      document.getElementById('uname').value = user.uname;
      document.getElementById('firstName').value = user.firstName;
      document.getElementById('lastName').value = user.lastName;
    })
  }
  

  // din kode her
  render() {
    return html`
      <style>
      span {
        width: 14em;
        display: inline-block;
        overflow: hidden;
      }
      body {
      width: 98%;
      height: 98vh;
    }

    body>section {
      width: 1024px;
      margin: 0 auto;
      height: 98%;
    }

    body>section>div {
      display: inline-block;
      width: 45%;
      padding: 5px;
      height: 100%;
      overflow-y: auto;
    }

    .users ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .users ul span:nth-child(odd) {
      width: 14em;
      display: inline-block;
      overflow: hidden;
    }

    label {
      display: inline-block;
      width: 7em;
    }

    .response {
      display: none;
    }

    input[type="submit"] {
      margin: 5px 0px;
    }

      </style>
      <form>
        <label for="uname">Brukernavn</label><input type="email" id="uname" name="uname" required pattern=".{6,}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Gyldig e-post adresse" value="${this.user.uname}"><br>
        <label for="firstName">Fornavn</label><input type="text" id="firstName" name="firstName" required pattern=".{1,}" title="Kan ikke være tomt" value="${this.user.firstName}"><br>
        <label for="lastName">Etternavn</label><input type="text" id="lastName" name="lastName" required pattern=".{1,}" title="Kan ikke være tomt" value="${this.user.lastName}"><br>
        <label for="oldpwd">Eksisterende passord</label><input type="password" id="oldpwd" name="oldpwd" required pattern=".{8,}" title="Minimum 8 tegn"><br>
        <label for="pwd">Passord</label><input type="password" id="pwd" name="pwd" pattern=".{8,}" title="Minimum 8 tegn"><br>
        <label for="pwd1">Bekreft passord</label><input type="password" id="pwd1" name="pwd1" pattern=".{8,}" title="Minimum 8 tegn"><br>
        <input type="submit" @click="${this._submit}" value="Oppdater informasjon">
        <div class="response" id="response"></div>
      </form>
    `;
  }

  /**
    * Called when the user clicks the submit button.
    *
    * @param  {Object} e event object from the click event
    */
   _submit(e) {
    e.preventDefault();

    const data = new FormData(e.target.form);
    data.append('uid', this.user.uid);
    fetch('api/updateUser.php', {
          method: 'POST',
          body: data
        }).then(res=>res.json())
        .then(data=>{
          const response = this.shadowRoot.getElementById('response');
          response.style.display = 'block';
          if (data.status=='success') {
            // location.reload(); // refresh user list after changes
            response.style.color = "#0B0";
            response.innerHTML = "Informasjon om brukeren er oppdatert";
            
          } else {
            response.style.color = "#F00";
            response.innerHTML = "Error: " + data.msg;
            console.log(data.msg);
          }
          setTimeout(()=> {
            response.style.display = 'none';
          }, 3000);
        })
   }
}
customElements.define('edit-user', EditUser);
