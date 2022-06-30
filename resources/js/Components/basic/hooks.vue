<template>
    <div>
        <h1 ref="elem">Hooks page</h1>
    </div>
</template>

<script>

export default ({
    date() {
        return {
            name: 'Developer'
        }
    },

    created() {
        console.log('Fetching data value', this.name);
    },

    mounted() {
        console.log(this.$refs.elem);
    }
})
</script>
