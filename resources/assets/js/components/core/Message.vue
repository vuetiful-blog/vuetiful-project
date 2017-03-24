<template>
    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
        <div class="ui ten wide left aligned column" v-show="show">
            <div class="ui error message">
                <div class="header">
                	<slot name="header"></slot>
                </div>
                <slot name="message"></slot>
                    
            </div>
        </div>
    </transition>
</template>

<script type="text/javascript">
export default {
    props: {
        show: {
            default: true
        },
        durationIn: {
            default: 300
        },
       durationOut: {
            default: 300
        }
    },
    methods: {
        slideFadeIn(el, done) {
            Velocity(el, "slideDown", {
                duration: this.durationIn
            });
            Velocity(el, {
                opacity: 1
            }, {
                complete: done
            });
        },
        fadeSlideOut(el, done) {
            Velocity(el, {
                opacity: 0
            }, {
                duration: this.durationOut
            });
            Velocity(el, "slideUp", {
                complete: done
            });
        }
    }
}
</script>
