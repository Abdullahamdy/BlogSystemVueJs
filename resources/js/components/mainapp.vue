<template>
    <div>
        <div v-if="$store.state.user">
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul" v-for="(MenuItem,i) in permissions" v-if="permissions.length" :key="i">
                            <li v-if="MenuItem.read">
                                <router-link :to='MenuItem.name' > {{ MenuItem.resourceName }}</router-link>
                            </li>
                            <!-- <li>
                                <router-link to='/tags'> Tag</router-link>
                            </li>
                            <li>
                                <router-link to='/category'> Category</router-link>
                            </li>
                            <li>
                                <router-link to='/adminusers'>
                                    <Icon type="ios-speedometer" /> Admin Users
                                </router-link>
                            </li>

                            <li><router-link to="role"><Icon type="ios-speedometer" /> Role Management</router-link></li>
                            <li><router-link to="assignRole"><Icon type="ios-speedometer" /> Assign role</router-link></li> -->

                            <!-- <li><router-link to="tags"><Icon type="ios-speedometer" /> Tags</router-link></li>
              <li><router-link to="category"><Icon type="ios-speedometer" /> Category</router-link></li>
              <li><router-link to="adminusers"><Icon type="ios-speedometer" /> Admin users</router-link></li>

            -->


        </ul>
        <li><a href="/logout">
                <Icon type="ios-speedometer" /> Logout
            </a></li>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view />
    </div>
</template>

<script>
export default {
    props:['user','permissions'],
    data() {
        return {
            isLoggedIn: false,
        }

    },
    created(){
        this.$store.commit('setUpdateUser',this.user)
        this.$store.commit('setUserPermission',this.permissions)

    }
}

</script>

