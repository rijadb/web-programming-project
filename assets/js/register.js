let registers = [];

$("#register-form").validate({
  rules: {
    firstName: {
      required: true,
      minlength: 2,
      maxlength: 50,
      normalizer: function (value) {
        return $.trim(value);
      },
    },
    lastName: {
      required: true,
      minlength: 2,
      maxlength: 50,
      normalizer: function (value) {
        return $.trim(value);
      },
    },
    email: {
      required: true,
      email: true,
      normalizer: function (value) {
        return $.trim(value);
      },
    },
    pwd: {
      required: true,
      minlength: 8,
      maxlength: 100,
      pattern: /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/, // at least one uppercase, one lowercase, one digit
      normalizer: function (value) {
        return $.trim(value);
      },
    },
    repeat_password: {
      required: true,
      equalTo: "#register-password",
    },
  },
  messages: {
    firstName: {
      required: "Please enter your first name",
    },
    lastName: {
      required: "Please enter your last name",
    },
    email: {
      required: "Please enter your email",
      email: "Please enter a valid email address",
    },
    pwd: {
      required: "Please enter a password",
    },
    repeat_password: {
      required: "Please repeat your password",
      equalTo: "Passwords do not match", // Message for password confirmation mismatch
    },
  },
  submitHandler: function (form, event) {
    event.preventDefault(); // da mi ne submita
    blockUi("body");
    let register = serializeForm(form);
    console.log(JSON.stringify(register));

    registers.push(register);
    console.log("CONTACTS = ", registers);

    $.post(Constants.get_api_base_url() + "users/add", register).done(
      function () {
        $("#register-form")[0].reset();

        unblockUi("body");

        toastr.success("User added successfully");
      }
    );
  },
});

blockUi = (element) => {
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
};

unblockUi = (element) => {
  $(element).unblock({});
};

serializeForm = (form) => {
  let jsonResult = {};
  //console.log($(form).serializeArray());
  //serializeArray() reutrns an array of: name: [name of filed], value: [value of filed] for each field in the form
  $.each($(form).serializeArray(), function () {
    jsonResult[this.name] = this.value;
  });
  return jsonResult;
};
