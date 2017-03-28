<template>
    <div>
        <div id="menu">
            <nav-menu @loading="showLoader('Logging Out')"></nav-menu>
        </div>

        <div :class="['ui', {active: loading}, 'dimmer']">
            <div class="ui text loader">{{loadingText}}</div>
        </div>

        <div id="content">
            <div class="ui aligned padded grid">
                <div class="column">
                    <div class="ui basic segment">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import NavMenu from './core/NavMenu.vue'
export default {
    components: {
        NavMenu
    },
    methods: {
        showLoader(text) {
            this.loading = true;
            this.loadingText = text;
        }
    },
    data() {
        return {
            loading: false,
            loadingText: ""
        }
    }
}
</script>
