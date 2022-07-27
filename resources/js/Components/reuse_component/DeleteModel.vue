<template>
    <div>
        <Modal v-model="getDeleteModelObj.showDeleteModel" width="360">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p>After this task is deleted, the downstream 10 tasks will not be implemented.</p>
                <p>Will you delete it?</p>
            </div>
            <template #footer>
                <Button type="error" size="large" long :loading="del_modal_loading" @click="deleteTag()">Delete</Button>
            </template>
        </Modal>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            del_modal_loading: false,
            deleteIndex: -1,
        }
    },

    methods: {
        async deleteTag () {
            this.del_modal_loading = true;
            const delete_response = await this.callApi('post', this.getDeleteModelObj.deleteUrl, {id: this.getDeleteModelObj.deleteId});

            if (delete_response.status === 200) {
                // delete data from tag array
                this.del_modal_loading = false;
                const delModelObj = {
                    showDeleteModel: false,
                    deleteUrl: this.getDeleteModelObj.deleteUrl,
                    deleteId: this.getDeleteModelObj.deleteId,
                    deleteIndex: this.getDeleteModelObj.deleteIndex,
                    isDeleted: true
                }
                this.$store.commit('deleteModel', delModelObj)
                this.success(delete_response.data.msg);
            }
        }
    },

    computed: {
        ...mapGetters([
            'getDeleteModelObj'
        ])
    }
}
</script>