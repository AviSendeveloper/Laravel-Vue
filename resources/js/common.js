export default {
    data() {
        return {

        }
    },

    methods: {
        // callApi(method, url, dataObj=null) {
        //     try {
        //         return new Promise((resolve, response) => {
        //             axios({
        //                 method: method,
        //                 url: url,
        //                 data: dataObj,
        //             }).then(function(response) {
        //                 resolve(response);
        //             });
        //         })
        //     } catch (error) {
                
        //     }
        // }

        async callApi(method, url, dataObj) {
            try {
                const response = await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                })
                return response;
            } catch (error) {
                // console.log('error block', error);
                return error;
            }
            
        },

        // Notification
        info (desc="This is info notification", title="Notification") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        success (desc="Operation completed successfully", title="Notification") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning (desc="Warning", title="Notification") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        error (desc="Something is wrong", title="Notification") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    }
}