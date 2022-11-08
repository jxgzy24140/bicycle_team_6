const checkExist = (username) => {
  for (i = 0; i < localStorage.length; i++) {
    return localStorage.key(i) == username ? true : false;
  }
};

const auth = () => {};

const handleLogin = () => {
  const username = document.querySelector(".username").value;
  const password = document.querySelector(".password").value;
  if (username.trim().length == 0 || password.trim().length == 0) {
    alert("Fill in");
  } else {
    if (checkExist(username)) {
      alert("username or password incorret! 1");
    } else {
      const objJson = localStorage.getItem(username);
      const obj = JSON.parse(objJson);
      const pwd = obj.password;
      if (password != pwd) {
        alert("username or password incorret! 2");
      } else {
        localStorage.setItem('auth', 1)
        window.location = "../home/index.html";
      }
    }
  }
};

