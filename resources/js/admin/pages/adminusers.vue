<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        Admin
                        <Button @click="addModal = true">
                            <Icon type="md-add" /> Add Admin
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>FullName</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(user, i) in users" :key="user.id" v-if="users.length > 0">
                                <td>{{ user.id }}</td>
                                <td class="_table_name">{{ user.fullName }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
                                    <Button @click="showDeletingModal(user, i)" type="error" size="small">Delete</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>
                <Modal v-model="addModal" title="Add Admin" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="data.fullName" placeholder="Full Name" />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Password" />
                    </div>

                        <div class="space">
                        <Select v-model="data.role_id" placeholder="select Role">
                            <Option v-for="role in roles" :value="role.id" :key="role.id" v-if="roles.length >0">{{ role.roleName }}</Option>

                        </Select>
                    </div>


                    <div slot="footer">
                        <Button type="default" @click="addModal = false">Close</Button>
                        <Button @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{
                            isAdding ? "Adding ..." : "Add Admin"
                        }}</Button>
                    </div>
                </Modal>
                <!-- edit modal -->
                <Modal v-model="editModal" title="edit Admin" :mask-closable="false" :closable="false">
                    <div class="space">

                        <Input v-model="editData.fullName" placeholder="Full Name" />
                    </div>
                    <div class="space">

                        <Input v-model="editData.email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input v-model="editData.password" placeholder="Password" />

                    </div>
                    <div class="space">
                        <Select v-model="editData.role_id"  placeholder="Select admin type">
                            <Option value="Admin" >Admin</Option>
                            <Option value="Editor" >Editor</Option>
                        </Select>
                    </div>



                    <div slot="footer">
                        <Button type="default" @click="closeEditModal = false">Close</Button>
                        <Button @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{
                            isAdding ? "Editing ..." : "Edit category"
                        }}</Button>
                    </div>
                </Modal>



                <!-- delete alert modal -->
                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>

<script>
  import deleteModal from "../components/deleteModal.vue";
  import { mapGetters } from "vuex";
export default {
    data() {
        return {
            data: {
                fullName: "",
                email: "",
                password: "",
                role_id:""
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            users: [],
            roles: [],
            editData: {
                fullName: "",
                email: "",
                password: "",
                role_id: "",
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            DeletingIndex: -1,
        };
    },
    methods: {
        async addAdmin() {
            const res = await this.callApi("post", "/app/create_user", this.data);
            console.log(res.status)
            if (res.status == 201) {
                console.log(res.data)
                this.users.unshift(res.data);
                this.s("User has been Added Successfully!");
                this.addModal = false;
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                }
            }
        },

        //edit data funciton
        async editAdmin() {
            if (this.editData.fullName.trim() == "")
                return this.e("full Name is required");
            const res = await this.callApi("post", "/app/edit_user", this.editData);
            if (res.status == 200) {
                this.users[this.index].fullName = this.editData.fullName;
                this.users[this.index].email = this.editData.email;
                this.users[this.index].role_id = this.editData.role_id;
                this.s("User has been updated Successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        //end edit data function

        async showEditModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
            };

            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        /// end edit tag

        //delete tag
        showDeletingModal(user, i) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "app/delete_user",
        data: user,
        deletingIndex: i,
        isDeleted: false
      };
      this.$store.commit("setDeletingModalObj", deleteModalObj);
       this.deletingIndex = i
    },
        //end delete tag
    },

    async created() {
        const [res,resRole] = await Promise.all([
        this.callApi("get", "/app/get_users"),
         this.callApi("get", "/app/get_roles"),
        ]);

        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.swr();
        }
        if (resRole.status == 200) {
            this.roles = resRole.data;
        } else {
            this.swr();
        }
    },
    components: {
    deleteModal
  },
  computed: {
    ...mapGetters(["getDeleteModalObj"])
  },
  watch: {
    getDeleteModalObj(obj) {
      if (obj.isDeleted) {
        this.users.splice(obj.deletingIndex, 1);
      }
    }
  }
};
</script>
