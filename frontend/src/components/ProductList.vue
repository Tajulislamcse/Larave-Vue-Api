<template>
    <div class="container">
       <table class="table table-hover">
        
          <thead> 
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>


            </tr>
        </thead>
          
        

        <tbody v-for="product in products" :key = "product.id">
            <tr>
            <td>{{product.name}}</td>
            <td>{{product.price}}</td>
            <td>{{product.description}}</td>
            <td>
            <a class="btn btn-danger" @click.prevent="deleteProduct(product.id)">Delete</a>
            </td>

            </tr>
        </tbody>

        </table> 

    </div>
</template>
<script>
import axios from 'axios';
export default {
    name:'ProductList',
    data()
    {
        return {
         products:Array
        }
    },
    created()
    {
          this.getProducts();
    },
    methods:
    {
        async getProducts()
        {
            let url = 'http://127.0.0.1:8000/api/products';
            await axios.get(url).then(response=>{
                  this.products = response.data.products;
                  console.log(this.products)
               

            }).catch(error=>
            {
              console.log(error);
            });
        }
        ,
      async deleteProduct(id)
      {
        if(confirm("Are You Sure")){
        let url = `http://127.0.0.1:8000/api/products/${id}`;
        await axios.delete(url).then(response=>{
    
         if(response.data.status==200)
         {
         alert(response.data.message);
         this.getProducts();
        }
      }).catch(error=>{
      console.log(error)
      });
        }
      
    }
    },

    
    mounted()
    {
        console.log('contact list component mounted');
    }
}

</script>