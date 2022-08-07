<template>
    <div>
        {{second}}
    </div>
</template>
<script>
export default {
    props: ['second'],
    data() {
        return {
            // Code...
            timer:null
        }
    },
    computed: {
        // Code...
    },
    created() {
        //start timer
        var parent = this;
        this.timer = setInterval(this.decrease,1000);
    },
    destroyed() {
        // Code...
    },
    methods: {
        // Code...
        decrease(){
            this.second--;
            if(this.second == 0){
                alert("finished!");
                clearInterval(this.timer);
            }
        }
    }
}
</script>

<style scoped>

</style>
