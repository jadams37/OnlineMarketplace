const validation = new JustValidate("#signup");

validation
    .addField("#username", [
        {
            rule: "required"
        },
        {
            validator: (value) => () => {
                return fetch("validate-username.php?username=" +
                encodeURIComponent(value))
                .then(function(response) {
                    return response.json();
                })
                .then(function(json) {
                    return json.available;
                });
            },
            errorMessage: "Username already taken"
        }
    ])
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" +
                encodeURIComponent(value))
                .then(function(response) {
                    return response.json();
                })
                .then(function(json) {
                    return json.available;
                });
            },
            errorMessage: "Email already in use"
        }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#address", [
        {
            rule: "required"
        },
    ])
    .addField("#phone", [
        {
            rule: "required"
        },
        {
            rule: "customRegexp",
            value: /^\d{3}-?\d{3}-?\d{4}$/,
            errorMessage: "Must be in format ###-###-####"
        }
    ])
    .addField("#firstname", [
        {
            rule: "required"
        },
    ])
    .addField("#lastname", [
        {
            rule: "required"
        },
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });