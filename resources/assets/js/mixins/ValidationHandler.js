var ValidationHandler = {
    methods: {
        getHtmlValidationErrors(response) {
            let message = '';
            // Loop through each error message and add it to our message variable
            Object.keys(response.data).forEach(item => {
            	let field = response.data[item];
            	for(let i = 0; i < field.length; i++){
                  message += field[i] + "<br />"; 		
            	}
            });

            return message;
        }
    }
}

export default ValidationHandler;
