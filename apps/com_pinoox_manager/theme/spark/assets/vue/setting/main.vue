<template>
    <section>
        <div id="settings">
            <div class="sidebar" data-simplebar>
                <router-link class="item back" :to="{name:'home'}">
                    <i class="fas fa-chevron-right"></i>&nbsp;
                    <span class="name"> {{LANG.manager.back}}</span>
                </router-link>
                <router-link v-for="menu in menus" exact-active-class="active" class="item" :to="{name:menu.name}">
                    <img v-if="menu.img!=null" :src="menu.img">
                    <i v-else class="fas" :class="menu.icon"></i>
                    &nbsp;<span class="name">{{LANG.manager[menu.label]}}</span>
                    <div class="notify-effect" v-if="notifyInstaller && menu.name === 'appManager-home'">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>
                    <div v-if="pinooxAuth.isLogin && menu.name === 'setting-market'">
                        <i class="fas fa-user-check"></i>
                    </div>
                </router-link>
            </div>
            <router-view></router-view>
        </div>
    </section>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                menus: [
                    {
                        name: 'setting-dashboard',
                        label: 'interface',
                        icon: 'fa-tv',
                    },
                    {
                        name: 'setting-account',
                        label: 'account',
                        icon: 'fa-user',
                    },
                    {
                        name: 'setting-router',
                        label: 'router',
                        icon: 'fas fa-code-branch',
                    },

                    {
                        name: 'appManager-home',
                        label: 'app_manager',
                        icon: 'fas fa-grip-horizontal',
                    },
                    {
                        name: 'setting-market',
                        label: 'market',
                        img: require('@img/market-icon.png'),
                    },
                    {
                        name: 'setting-about',
                        label: 'about',
                        img: require('@img/pin-icon.png'),
                    },
                ]
            }
        },
        computed: {
            pinooxAuth: {
                get() {
                    return this.$store.state.pinooxAuth;
                }
            },
            notifyInstaller: {
                get() {
                    return this.$store.state.readyInstallCount;
                }
            }
        }
    }
</script>

