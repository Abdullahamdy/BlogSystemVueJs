<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div
          class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
        >
          <p class="_title0">
            Tags
            <Button @click="addModal = true"
              ><Icon type="md-add" /> Add Category</Button
            >
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr
                v-for="(category, i) in categories"
                :key="category.id"
                v-if="categories.length > 0"
              >
                <td>{{ category.id }}</td>
                <td class="_table_name">{{ category.categoryName }}</td>
                <td>{{ category.created_at }}</td>
                <td>
                  <Button
                    type="info"
                    size="small"
                    @click="showEditModal(category, i)"
                    >Edit</Button
                  >
                  <Button
                    @click="showDeletingModal(category, i)"
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
          title="Add tag"
          :mask-closable="false"
          :closable="false"
        >
          <Upload
          ref="uploads"
            type="drag"
            :headers="{
              'x-csrf-token': token,
              'X-Requested-With': 'XMLHttpRequest',
            }"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg', 'jpeg', 'png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload"
          >
            <div style="padding: 20px 0">
              <Icon
                type="ios-cloud-upload"
                size="52"
                style="color: #3399ff"
              ></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <div class="demo-upload-list" v-if="data.iconImage">
            <img :src="`uploads/${data.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>

          <Input v-model="data.categoryName" placeholder="Add Category name" />

          <div slot="footer">
            <Button type="default" @click="addModal = false">Close</Button>
            <Button @click="addTag" :disabled="isAdding" :loading="isAdding">{{
              isAdding ? "Adding ..." : "Add tag"
            }}</Button>
          </div>
        </Modal>
        <!-- edit modal -->
        <Modal
          v-model="editModal"
          title="edit tag"
          :mask-closable="false"
          :closable="false"
        >
          <Input v-model="editData.tagName" placeholder="Edit tag name" />

          <div slot="footer">
            <Button type="default" @click="editModal = false">Close</Button>
            <Button @click="editTag" :disabled="isAdding" :loading="isAdding">{{
              isAdding ? "Editing ..." : "Edit tag"
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
            <p>Are you sure Delete this Tag</p>
          </div>
          <div slot="footer">
            <Button type="default" size="large" @click="showDeleteModal = false"
              >Close</Button
            >
            <Button
              type="error"
              size="large"
              :loading="isDeleting"
              :disabled="isDeleting"
              @click="Deletetag"
              >Deletee</Button
            >
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
        iconImage: "",
        categoryName: "",
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      categories: [],
      editData: {
        tagName: "",
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      DeletingIndex: -1,
      token: "",
    };
  },
  methods: {
    async addTag() {
      if (this.data.categoryName.trim() == "")
        return this.e("Tag Name is required");
      const res = await this.callApi("post", "/app/create_tag", this.data);
      if (res.status == 200) {
        this.categories.unshift(res.data.category);
        this.s("Tag has been Added Successfully!");
        this.addModal = false;
        this.data.tagName = "";
      } else {
        if ((res.status = 422)) {
          if (res.data.errors.tagName) {
            this.e(res.data.errors.tagName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async deleteImage() {
        let image = this.data.iconImage ;
        this.data.iconImage = "";
        this.$refs.uploads.clearFiles();
      const res = await this.callApi("post", "/app/delete-img", {imageName:image});
      if(res.status != 200){
        this.data.iconImage = image;
        this.swr();
      }
    },

    //edit data funciton
    async editTag() {
      if (this.editData.tagName.trim() == "")
        return this.e("Tag Name is required");
      const res = await this.callApi("post", "/app/edit_tag", this.editData);
      if (res.status == 200) {
        this.tags[this.index].tagName = this.editData.tagName;
        this.s("Tag has been updated Successfully!");
        this.editModal = false;
      } else {
        if ((res.status = 422)) {
          if (res.data.errors.tagName) {
            this.e(res.data.errors.tagName[0]);
          }
        } else {
          this.swr();
        }
      }
    },

    //end edit data function

    async showEditModal(tag, index) {
      let obj = {
        id: tag.id,
        tagName: tag.tagName,
      };

      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    /// end edit tag

    //delete tag

    async Deletetag() {
      this.isDeleting = true;
      const res = await this.callApi(
        "post",
        "/app/delete_tag",
        this.deleteItem
      );
      if (res.status == 200) {
        this.tags.splice(this.DeletingIndex, 1);
        this.s("Tag has been deleteted successfully");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.showDeleteModal = false;
    },

    showDeletingModal(tag, i) {
      console.log(tag);
      this.deleteItem = tag;
      this.DeletingIndex = i;
      this.showDeleteModal = true;
    },
    //end delete tag

    //file funciton

    handleSuccess(res, file) {
      this.data.iconImage = res;
    },
    handleError(res, file) {
      this.$Notice.warning({
        title: "file format is incorrect",
        desc: `${
          file.errors.file.length ? file.errors.file[0] : " Something wrong"
        }`,
      });
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc:
          "File format of " +
          file.name +
          " is incorrect, please select jpg or png.",
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: "Exceeding file size limit",
        desc: "File  " + file.name + " is too large, no more than 2M.",
      });
    },
  },

  async created() {
    this.token = window.Laravel.csrfToken;
    const res = await this.callApi("get", "/app/get_categories");
    if (res.status == 200) {
      this.categories = res.data;
    } else {
      this.swr();
    }
  },
};
</script>
