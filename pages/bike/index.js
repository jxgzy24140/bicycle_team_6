const getApi = async (api, callback) => {
  let response = await fetch(api);
  let data = await response.json();
  callback(data);
};

getApi(api, (bikes) => {
  renderUsers(bikes.data);
});

const renderUsers = (bikes) => {
  const contentElement = document.querySelector(".content__product");
  const htmls = "";
  htmls = bikes.map((bike) => {
    return `
        <div class="item item1">
        <div class="item__img">
          <img src="" alt="" />
        </div>
        <p class="title"></p>
      </div>
        `;
  });
  contentElement.innerHTML = htmls.join('')
};
