import { createStore } from 'vuex';

const store = createStore({
    state: {
        counter: 1000,
        deleteModelObj: {
            showDeleteModel: false,
            deleteUrl: '',
            deleteId: 0,
            deleteIndex: -1,
            isDeleted: false
        }
    },

    getters: {
        getCount(state) {
            return state.counter;
        },

        getDeleteModelObj(state) {
            return state.deleteModelObj;
        }
    },

    mutations: {
        increaseStateCount(state, count) {
            state.counter += count;
        },

        showDeleteModel(state, data) {
            state.deleteModelObj = data
        },

        deleteModel(state, data) {
            state.deleteModelObj = data
        }
    },

    actions: {
        increaseStateCountAction({commit}, data) {
            // console.log(commit);
            commit('increaseStateCount', data)
        }
    }
});

export default store;