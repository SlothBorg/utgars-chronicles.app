<template>
    <Modal title="Create Event" @close="$emit('close')">
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input type="text" id="name" class="input" v-model="form.name">
            </div>

            <div class="mb-4">
                <label for="name" class="label">Description</label>
                <textarea id="description" rows="4" class="input" v-model="form.description"></textarea>
            </div>

            <div class="mb-4">
                <p class="label">Tone</p>

                <div class="flex justify-between items-center">
                    <div>
                        <input type="radio" id="light" value="light" v-model="form.type">
                        <label for="light">Light</label>
                    </div>

                    <div>
                        <input type="radio" id="dark" value="dark" v-model="form.type">
                        <label for="dark">Dark</label>
                    </div>
                </div>
            </div>

            <LoadingButton :loading="loading">
                Finish and add event
            </LoadingButton>
        </form>
    </Modal>
</template>

<script>
import axios from 'axios';

import Modal from "../Modal";
import LoadingButton from "../LoadingButton";

export default {
    name: "CreateEventModal",

    props: ['period', 'position'],

    inject: ['history'],

    components: {
        LoadingButton,
        Modal,
    },

    data() {
        return {
            loading: false,
            form: {
                name: null,
                description: null,
                type: 'dark',
                position: this.position,
            },
        };
    },

    methods: {
        submit() {
            this.loading = true;

            axios.post(this.$route('periods.events.store', [this.history, this.period]), this.form)
                .then(() => this.$emit('close'))
                .finally(() => this.loading = false);
        },
    },

    mounted() {
        this.$nextTick(() => this.$refs.input.focus());
    },
};
</script>
