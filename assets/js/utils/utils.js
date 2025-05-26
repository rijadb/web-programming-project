const Utils = {
  block_ui: function (element) {
    $(element).block({
      message: '<div class="spinner-border text-primary" role="status"></div>',
      css: {
        backgroundColor: "transparent",
        border: "0",
      },
      overlayCSS: {
        backgroundColor: "#000000",
        opacity: 0.25,
      },
    });
  },
  unblock_ui: function (element) {
    $(element).unblock({});
  },
  set_to_localstorage: function (key, value) {
    window.localStorage.setItem(key, JSON.stringify(value));
  },
  get_from_localstorage: function (key) {
    return window.localStorage.getItem(key);
  },
  get_localstorage_user_value: function (key) {
    return JSON.parse(this.get_from_localstorage("user"))[key];
  },
  logout: function () {
    if (confirm("Are you sure you want to log out of your account?")) {
      window.localStorage.clear();
      window.location.reload();
    } else {
      console.log("Cancelled logout");
    }
  },
};
