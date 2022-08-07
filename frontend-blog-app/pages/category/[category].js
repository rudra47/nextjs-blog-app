import {useRouter} from "next/router";

const Category = () => {
    const router = useRouter();
    const {category} = router.query;
    return (
        <div>
            <h1>Category {category}</h1>
        </div>
    );
}

export default Category;
