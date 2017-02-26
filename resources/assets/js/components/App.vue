<template>
    <div>
        <div id="menu">
            <nav-menu></nav-menu>
        </div>

        <div id="content">
            <div class="ui aligned padded grid" :style="{'min-height' : minHeight + 'px'}">
                <div class="column">
                    <div class="ui basic segment">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer">
            <site-footer></site-footer>
        </div>
    </div>
</template>

<script type="text/javascript">
import NavMenu from './core/NavMenu.vue'
import SiteFooter from './core/SiteFooter.vue'
export default {
    components: {
        NavMenu,
        SiteFooter
    },
    created() {
        window.addEventListener('resize', () => {
            this.calculateMinHeight()
        });
    },
    mounted() {
        this.calculateMinHeight()
    },
    methods: {
        calculateMinHeight() {
            let menuHeight = document.getElementById('menu').clientHeight;
            let footerHeight = document.getElementById('footer').clientHeight;
            this.minHeight = window.innerHeight - menuHeight - footerHeight;
        }
    },
    data() {
        return {
            minHeight: 0
        }
    }
}
</script>
