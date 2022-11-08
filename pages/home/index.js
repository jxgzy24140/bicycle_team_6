
// const handleCreate = async (url, data) => {
//     const config = {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify(data),
//     };
//     const fetchRes = await fetch(url, config);
//     const resData = await fetchRes.json();
//     //return resData;
//   };

// const handleCreateReservation = () => {
//     const name = document.querySelector('.name').value
//     const phone = document.querySelector('.phone').value
//     const email = document.querySelector('.email').value
//     const location = document.querySelector('.location').value
//     const startDate = document.querySelector('.startDate').value
//     const returnDate = document.querySelector('.endDate').value
//     const type = document.querySelector('.type').value
//     const reservationData = {
//         name: name,
//         phone: phone,
//         email: email,
//         location: location,
//         startDate: startDate,
//         returnDate: returnDate,
//         type: type
//     }
//     handleCreate('',reservationData)
// }

const auth = localStorage.getItem('auth') ?? ''

if(auth == 1) {
  const profileElement = document.querySelector(".profile");
  profileElement.classList.remove("hide");
  profileElement.classList.add("show");
}

console.log(123);