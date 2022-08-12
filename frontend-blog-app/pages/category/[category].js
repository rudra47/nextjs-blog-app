import axios from "axios";
import {useEffect, useState} from "react";
import {useRouter} from "next/router";

const Category = ({category, name}) => {
    const router = useRouter();
    const tag = router.query.category;
    const [post, setPost] = useState();

    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/posts');
            setPost(response.data);
        }catch (err){
            console.log(err);
        }
    }

    useEffect(  () => {
        fetchData();
        console.log('response ', post);
    }, []);

    return (
        <div>
            {console.log(post)}
            <h1>Category {category} {name}</h1>
        </div>
    );
}

export default Category;

export async function getStaticPaths(){
    const paths = [
        {params: {category: "web"}},
        {params: {category: "travel"}},
    ];
    return {paths, fallback: false}
}

export async function getStaticProps(pamams){
    const category = pamams.params.category;
    return {
        props: {
            category, name: "Rudra"
        }
    }
}
