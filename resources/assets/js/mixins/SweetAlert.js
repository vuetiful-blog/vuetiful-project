var SweetAlert = {
    methods: {
        alert(options) {
            return swal(options);
        },
        alertSuccess({ title = "Success!", text = "That's all done!", timer = 1000, showConfirmationButton = false } = {}) {
            return new Promise((resolve, reject) => {
                this.alert({
                    title: title,
                    text: text,
                    timer: timer,
                    showConfirmButton: showConfirmationButton,
                    type: 'success'
                }).then(() => {
                    resolve();
                }, dismiss => {
                    resolve();
                })
            });
        },
        alertError({ title = "Error!", text = "Oops...Something went wrong", html = "" } = {}) {
            return new Promise((resolve, reject) => {
                this.alert({
                    title: title,
                    html: html,
                    text: text,
                    type: 'error'
                }).then(() => {
                    resolve();
                }, dismiss => {
                    resolve();
                });
            });
        },
        confirm(options = {}) {
            options = Object.assign({
                title: "Are you sure?",
                text: "Are you sure you want to do that?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }, options);

            return this.alert(options);
        }
    }
}

export default SweetAlert;
