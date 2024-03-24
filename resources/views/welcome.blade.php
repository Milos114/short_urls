<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Url shortener</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    </head>
    <body>
             <div id="app">
                 <div class="col-10 position-absolute top-50 start-50 translate-middle">
                     <h2>URLs shortener</h2>
                     <div >
                         <div class="alert alert-danger" role="alert" v-if="error">
                             @{{error}}
                         </div>
                         <form class="" @submit.prevent="submit">
                             <input v-model="url" @keydown="error=false" type="text" class="form-control input-group mb-3" placeholder="Insert long url" aria-label="Insert url">
                             <div class="form-check form-switch">
                                 <input v-model="safe_check" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                 <label class="form-check-label text-sm" for="flexSwitchCheckDefault"><small>Check Url by using "Google Safe Browsing API" (requires GOOGLE_API_KEY in .env)</small></label>
                             </div>
                             <button class="btn btn-outline-secondary mt-4" type="submit">Submit</button>
                         </form>
                     </div>

                     <div class="input-group mt-5" >

                         <table class="table" v-if="urls.data?.length">
                             <thead>
                             <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Short url</th>
                                 <th scope="col">Long url</th>
                                 <th scope="col">Delete</th>
                             </tr>
                             </thead>
                             <tbody>
                             <tr v-for="(item, index) in urls.data" :key="index">
                                 <th scope="row" v-text="item.id"></th>
                                 <td>
                                     <a :href="item.long_url" v-text="item.short_url"></a>
                                 </td>
                                 <td v-text="item.long_url"></td>
                                 <td @click="remove(item.id)"><a href="#" v-text="'remove'"></a></td>
                             </tr>
                             </tbody>
                         </table>
                     </div>

                 </div>
             </div>

             <script>
                 data = {
                     data() {
                         return {
                             url: '',
                             urls: '',
                             error: '',
                             safe_check: false,
                         }
                     },

                     methods: {
                         submit() {
                             fetch('/api/store', {
                                 method: 'POST',
                                 headers: {
                                     'Content-Type': 'application/json',
                                     'Accept': 'application/json',
                                 },
                                 body: JSON.stringify({url: this.url, safe_check: this.safe_check})
                             }).then((response) => {
                                 response.json()
                                     .then((data) => {
                                         if (data.errors) {
                                             this.error = data.message
                                             return
                                         }
                                         this.urls.data.push(data.data);
                                         this.url = ''
                                     });
                             });
                         },

                         remove(id) {
                             fetch('/api/delete/'+id, {
                                 method: 'DELETE',
                                 headers: {
                                     'Content-Type': 'application/json'
                                 },
                             }).then((response) => {
                                 response.json()
                                     .then((data) => {
                                         this.urls.data = this.urls.data.filter(data => data.id !== id);
                                     });
                             });
                         },
                     },

                     mounted() {
                         fetch('/api/index', {
                                 method: "GET",
                                 headers: {
                                     'Content-Type': 'application/json'
                                 },
                             }).then((response) => {
                                 response.json()
                                     .then((data) => {
                                     this.urls = data;
                                 });
                             });
                     }
                 }

                 Vue.createApp(data).mount('#app')
             </script>
    </body>
</html>
