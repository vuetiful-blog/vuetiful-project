<template>
    <div class="ui fluid card">
        <div class="content">
            <div class="left floated">Posted in
                <span v-for="(category, index) in categories">
                <router-link :to="category.link">{{category.name}}</router-link><span v-if="!isLast(index)">, </span>
                </span>
            </div>
        </div>
        <div class="content">
            <div class="header">
                <router-link to="/">
                    <slot name="title"></slot>
                </router-link>
            </div>
            <div class="meta">Published
                <slot name="published"></slot>
            </div>
            <div class="description">
                <slot name="description"></slot>
            </div>
        </div>
        <div class="extra content">
            <span class="right floated">
      <i class="heart outline like icon"></i>
      {{likes}} likes
    </span>
            <i class="comment icon"></i> {{comments}} comments
        </div>
    </div>
    </div>
</template>

<script type="text/javascript">
export default {
    props: {
        comments: {
            default: 0,
            type: Number
        },
        likes: {
            default: 0,
            type: Number
        },
        categories: {
            default: function() {
                return [{
                    link: "/",
                    name: "Unknown"
                }]
            }
        }
    },
    methods: {
        isLast(index) {
            return this.categories.length - 1 === index;
        }
    }
}
</script>
