<template>
    <div>
        <div id="menu">
            <nav-menu></nav-menu>
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
    }
}
</script>
