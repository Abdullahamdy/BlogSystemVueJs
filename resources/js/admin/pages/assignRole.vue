<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        Roles Managment
                        <Select v-model="data.role_id" placeholder="select Role" style="width: 350px">
                            <Option v-for="role in roles" :value="role.id" :key="role.id" v-if="roles.length > 0">{{
                                role.roleName }}</Option>
                        </Select>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Resource Name</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(r,i) in resources" :key="i">
                                <td>{{ r.resourceName }}</td>
                               <td><Checkbox v-model="r.read">Read</Checkbox></td>
                               <td><Checkbox v-model="r.write">Write</Checkbox></td>
                               <td><Checkbox v-model="r.update">Update</Checkbox></td>
                               <td><Checkbox v-model="r.delete">Delete</Checkbox></td>

                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
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
                roleName: "",
                role_id: null,
            },
            roles:[],
            resources: [
                {resourceName:'Tags', read:false,write:false,update:false,delete:false,name:'tags'},
                {resourceName:'Role', read:false,write:false,update:false,delete:false,name:'role'},
                {resourceName:'Assign Role', read:false,write:false,update:false,delete:false,name:'assignRole'},
                {resourceName:'Adminusers', read:false,write:false,update:false,delete:false,name:'adminusers'},
                {resourceName:'Category', read:false,write:false,update:false,delete:false,name:'category'},
                {resourceName:'Home', read:false,write:false,update:false,delete:false,name:'home'},
            ],
        };
    },
    methods: {

    },

    async created() {

        const res = await this.callApi("get", "/app/get_roles")
        if (res.status == 200) {
            this.roles = res.data;
        } else {
            this.swr();
        }
    },
};
</script>
