const checkUniq = (username) => {
  for (i = 0; i < localStorage.length; i++) {
    key = localStorage.key(i);
    return key === username ? true : false;
  }
};

const handleAddNewMem = () => {
  const username = document.querySelector(".username").value;
  const password = document.querySelector(".password").value;
  const rpassword = document.querySelector(".rpassword").value;
  if (checkUniq(username)) {
    alert("The username is already used!");
  } else {
    if (password !== rpassword) {
      alert("Your repeat-password not match!");
      window.location = "";
    } else {
      const data = {
        username: username,
        password: password,
        auth: 1,
      };
      localStorage.setItem(username, JSON.stringify(data));
      window.location = "login.html";
    }
  }
};
