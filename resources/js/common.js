import { mapGetters } from "vuex";
export default
    {
        data(){
            return{

            }
        },
        methods:{
            async callApi(method,url,dataObj){
                try{
                 return  await axios({
                        method:method,
                        url:url,
                        data:dataObj
                    });
                }catch(e){
                    return e.response;

                }

            },
            i(desc, title="Hey") {
                this.$Notice.info({
                    title: title,
                    desc: desc
                });
            },
            s(desc, title="Great!") {
                this.$Notice.success({
                    title: title,
                    desc: desc
                });
            },
            w(desc, title="Oops!") {
                this.$Notice.warning({
                    title: title,
                    desc: desc
                });
            },
            e(desc, title="Oops!") {
                this.$Notice.error({
                    title: title,
                    desc: desc
                });
            },
            swr(desc='Somethingn went wrong! Please try again.', title="Oops") {
                this.$Notice.error({
                    title: title,
                    desc: desc
                });
            },
            checkUserPermissions(key){
                if(!this.userPermission)return true;
                let isPremitted = false;
                for(let d of this.userPermission){
                    if(this.$route.name == d.name){
                    if(d[key]){
                        isPremitted = true;
                        break;

                    }else{
                        break;
                    }
                }
            }
            return isPremitted;

            },

        },
        computed: {
           ...mapGetters({
            'userPermission' : 'getUserPermission'
        }),
            isReadPermitted(){
               return this.checkUserPermissions('read')

            },
            isWritePermitted(){
                return this.checkUserPermissions('write')

            },
            isUpdatePermitted(){
                return this.checkUserPermissions('update')

            },
            isDeletePermitted(){
                return this.checkUserPermissions('delete')

            }
          },

    }
