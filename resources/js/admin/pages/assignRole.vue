<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        Roles Managment
                        <Select v-model="data.id" placeholder="select Role" style="width: 350px"   @on-change="changeAdmin">
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
                            <tr v-for="(r, i) in resources" :key="i">
                                <td>{{ r.resourceName }}</td>
                                <td>
                                    <Checkbox v-model="r.read">Read</Checkbox>
                                </td>
                                <td>
                                    <Checkbox v-model="r.write">Write</Checkbox>
                                </td>
                                <td>
                                    <Checkbox v-model="r.update">Update</Checkbox>
                                </td>
                                <td>
                                    <Checkbox v-model="r.delete">Delete</Checkbox>
                                </td>

                            </tr>
                            <!-- ITEMS -->
                            <div class="button_center">
                                <Button style="margin-top: 10px;" type="primary" :loading="isSending" :disabled="isSending"
                                    @click="assignRole">Assign</Button>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let log = console.log;
export default {
    data() {
        return {
            data: {
                roleName: "",
                id: null,
            },
            isSending: false,
            roles: [],
            resources: [
                { resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/' },
                { resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags' },
                { resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role' },
                { resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, name: 'createblogs' },
                { resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole' },
                { resourceName: 'Adminusers', read: false, write: false, update: false, delete: false, name: 'adminusers' },
                { resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category' },
            ],
            defaultPermission: [
                { resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/' },
                { resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags' },
                { resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role' },
                { resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, name: 'createblogs' },
                { resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole' },
                { resourceName: 'Adminusers', read: false, write: false, update: false, delete: false, name: 'adminusers' },
                { resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category' },
            ],
        };
    },
    methods: {
        async assignRole() {
            let data = JSON.stringify(this.resources);
            const res = await this.callApi('post', 'app/assign_role', { 'permission': data, id: this.data.id })
            if (res.status == 200) {
                this.s('Role has been updated successfully');
                  let index =  this.roles.findIndex(x => x.id === this.data.id);
                   this.roles[index].permission = data
            } else {
                this.swr();
            }
        },
        changeAdmin(){
           let index =  this.roles.findIndex(x => x.id === this.data.id);
           let permission = this.roles[index].permission;
           if(!permission){
            this.resources = this.defaultPermission
           }else{
            this.resources = JSON.parse(permission)
           }

        }

    },

    async created() {

        const res = await this.callApi("get", "/app/get_roles")
        if (res.status == 200) {
            this.roles = res.data;
            if (res.data.length) {
                this.data.id = res.data[3].id;
                if (res.data[3].permission)
                    this.resources = JSON.parse(res.data[3].permission)
            }
        } else {
            this.swr();
        }
    },
};
</script>
