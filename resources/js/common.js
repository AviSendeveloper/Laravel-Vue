export default {
    data() {
        return {

        }
    },

    methods: {
        async callApi(method, url, dataObj) {
            try {
                await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                }).then(function(response) {
                    return response;
                });
            } catch (error) {

            }
        }
    }
}