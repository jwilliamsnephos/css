<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Events</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Name *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="useInTb1">Use In Tie Breaker 1</label>
                                    <input
                                            type="checkbox"
                                            name="useInTb1"
                                            v-model="useInTb1"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="useInTb2">Use In Tie Breaker 2</label>
                                    <input
                                            type="checkbox"
                                            name="useInTb2"
                                            v-model="useInTb2"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="useInTb3">Use In Tie Breaker 3</label>
                                    <input
                                            type="checkbox"
                                            name="useInTb3"
                                            v-model="useInTb3"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="useInTb4">Use In Tie Breaker 4</label>
                                    <input
                                            type="checkbox"
                                            name="useInTb4"
                                            v-model="useInTb4"
                                            >
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('EventsSingle', ['item', 'loading']),
        useInTb1: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_1;
            },
            set(value) {
                this.setUseInTb1(value);
            }
        },
        useInTb2: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_2;
            },
            set(value) {
                this.setUseInTb2(value);
            }
        },
        useInTb3: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_3;
            },
            set(value) {
                this.setUseInTb3(value);
            }
        },
        useInTb4: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_4;
            },
            set(value) {
                this.setUseInTb4(value);
            }
        },
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('EventsSingle', ['fetchData', 'updateData', 'resetState', 'setName', 'setUseInTb1', 'setUseInTb2', 'setUseInTb3', 'setUseInTb4']),
        updateName(e) {
            this.setName(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'events.index' })
                    this.$eventHub.$emit('update-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
