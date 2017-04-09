<template>
    <div :class="['ui', {active: loading}, {inverted: inverted}, {dimmer: dimmer}]">
        <div class="ui text loader">{{loadingText}}</div>
    </div>
</template>

<script type="text/javascript">
export default {
    props: {
        loadingText: {
            default: '',
            type: String
        },
        loading: {
            default: false,
            type: Boolean
        },
        inverted: {
            default: true,
            type: Boolean
        },
        dimmer: {
            default: true,
            type: Boolean
        }
    }
}
</script>
