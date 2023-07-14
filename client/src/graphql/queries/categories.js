
import gql from "graphql-tag";

function categoriesQuery() {
 return  gql`
 query {
   categories {
     id
     name
   }
 }
`
}
export default categoriesQuery;