<template>
    <div>
      <div class="content">
        <div class="container-fluid">
          <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
          <div
            class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
          >
            <p class="_title0">
              Roles Managment
              <Button @click="addModal = true"
                ><Icon type="md-add" /> Add Role</Button
              >
            </p>

            <div class="_overflow _table_div">
              <table class="_table">
                <!-- TABLE TITLE -->
                <tr>
                  <th>ID</th>
                  <th>Role Name</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
                <!-- TABLE TITLE -->

                <!-- ITEMS -->
                <tr v-for="(role, i) in roles" :key="role.id" v-if="roles.length > 0">
                  <td>{{ role.id }}</td>
                  <td class="_table_name">{{ role.roleName }}</td>
                  <td>{{ role.created_at }}</td>
                  <td>
                    <Button
                      type="info"
                      size="small"
                      @click="showEditModal(role, i)"
                      >Edit</Button
                    >
                    <Button
                    @click="showDeletingModal(role,i)"
                      type="error"
                      size="small"
                      >Delete</Button
                    >
                  </td>
                </tr>
                <!-- ITEMS -->
              </table>
            </div>
          </div>
          <Modal
            v-model="addModal"
            title="Add Role"
            :mask-closable="false"
            :closable="false"
          >
            <Input v-model="data.roleName" placeholder="Add Role Name" />

            <div slot="footer">
              <Button type="default" @click="addModal = false">Close</Button>
              <Button @click="addRole" :disabled="isAdding" :loading="isAdding">{{
                isAdding ? "Adding ..." : "Add Role"
              }}</Button>
            </div>
          </Modal>
          <!-- edit modal -->
          <Modal
            v-model="editModal"
            title="Edit Role"
            :mask-closable="false"
            :closable="false"
          >
            <Input v-model="editData.roleName" placeholder="Edit Role name" />

            <div slot="footer">
              <Button type="default" @click="editModal = false">Close</Button>
              <Button @click="editRole" :disabled="isAdding" :loading="isAdding">{{
                isAdding ? "Editing ..." : "Edit Role"
              }}</Button>
            </div>
          </Modal>

          <!-- delete alert modal -->
          <Modal
            :value="showDeleteModal"
            :mask-closable="false"
            :closable="false"
            width="360"
          >
            <p slot="header" style="color: #f60; text-align: center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete confirmation!</span>
            </p>
            <div style="text-align: center">
              <p>Are you sure Delete this Role</p>
            </div>
            <div slot="footer">
              <Button type="default" size="large" @click="showDeleteModal = false"
                >Close</Button
              >
              <Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="Deleterole">Deletee</Button>
            </div>
          </Modal>
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
        },
        addModal: false,
        editModal: false,
        isAdding: false,
        roles: [],
        editData: {
          roleName: "",
        },
        index: -1,
        showDeleteModal: false,
        isDeleting:false,
        deleteItem:{},
        DeletingIndex:-1,
      };
    },
    methods: {
      async addRole() {
        if (this.data.roleName.trim() == "") return this.e("role Name is required");
        const res = await this.callApi("post", "/app/create_role", this.data);
        if (res.status == 200) {
          this.roles.unshift(res.data.role);
          this.s("role has been Added Successfully!");
          this.addModal = false;
          this.data.roleName = "";
        } else {
          if ((res.status = 422)) {
            if (res.data.errors.roleName) {
              this.e(res.data.errors.roleName[0]);
            }
          } else {
            this.swr();
          }
        }
      },

      //edit data funciton
      async editRole() {
        if (this.editData.roleName.trim() == "")
          return this.e("Role Name is required");
        const res = await this.callApi("post", "/app/edit_role", this.editData);
        if (res.status == 200) {
          this.roles[this.index].roleName = this.editData.roleName;
          this.s("Role has been updated Successfully!");
          this.editModal = false;
        } else {
          if ((res.status = 422)) {
            if (res.data.errors.roleName) {
              this.e(res.data.errors.roleName[0]);
            }
          } else {
            this.swr();
          }
        }
      },

      //end edit data function

      async showEditModal(role, index) {
        let obj = {
          id: role.id,
          roleName: role.roleName,
        };

        this.editData = obj;
        this.editModal = true;
        this.index = index;
      },
      /// end edit Role

      //delete Role


      async Deleterole() {
          this.isDeleting = true;
        const res = await this.callApi("post", "/app/delete_role", this.deleteItem);
        if (res.status == 200) {
          this.roles.splice(this.DeletingIndex, 1);
          this.s("Role has been deleteted successfully");
        } else {
          this.swr();
        }
        this.isDeleting = false;
        this.showDeleteModal = false;
      },


      showDeletingModal(role,i){
          this.deleteItem = role;
          this.DeletingIndex = i;
          this.showDeleteModal = true;

      },
      //end delete role
    },

    async created() {
      const res = await this.callApi("get", "/app/get_roles");
      if (res.status == 200) {
        this.roles = res.data;
      } else {
        this.swr();
      }
    },
  };
  </script>
