<template>
    <div v-if="isLoggedIn == false">
        <div class="container">
            <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h2>Login To Dashboard</h2>
                </div>
                <div class="space">
                    <Input type="email" v-model="data.email" placeholder="Full Name" />
                </div>
                <div class="space">
                    <Input type="password" v-model="data.password" placeholder="Email" />
                </div>
                <div class="login_footer">
                    <Button type="primary" @click="login">Login</Button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {
                email: "",
                password: "",
            },
            isLoggedIn: false,
        }
    },
    methods: {
        async login() {
            if (this.data.email.trim() == "") return this.e("Email is Required")
            if (this.data.password.trim() == "") return this.e("Password is Required")
            if (this.data.password.length < 8) return this.e("Password is To Short")
            const res = await this.callApi("post", "/app/admin_login", this.data);
            if (res.status == 200) {
                this.s(res.data.msg)
                window.location = '/'

            }else if(res.status = 422){
                for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
            } else {
                if (res.status == 401) {
                    this.i(res.data.msg)
                }else{
                    this.swr();
                }
            }
            this.isLoggedIn = false
        }
    }
}
</script>
<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 220px;
}

.login_footer {
    text-align: center;

}

.login_footer Button {
    margin-top: 10px;

}

.login_header {
    text-align: center;
    background-color: green;
    border-radius: 5px;

}

.login_header h2 {
    color: aliceblue;

}</style>
