import Head from 'next/head'
import Image from 'next/image'
import styles from '../styles/Home.module.css'

export default function Me() {
  return (
    <div className={styles.container}>
      <Head>
        <title>About me</title>
        <meta name="description" content="Create first page" />
        <link rel="icon" href="/favicon.ico" />
      </Head>

      <main className={styles.main}>
        <h1 className={styles.title}>
          Welcome to <a href="#">About me page!</a>
        </h1>

        <div className={styles.grid}>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur culpa, ducimus ea labore quas saepe unde vitae. Consequatur minima officiis sunt unde? Aliquam asperiores dignissimos facilis itaque nesciunt reiciendis velit?
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab at blanditiis in, quasi sed voluptates?
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, dicta dignissimos est expedita laborum minus molestias mollitia nobis odio officia possimus, voluptates. Dolorem, ducimus explicabo. Animi omnis rerum sint tenetur!
          </p>

        </div>
      </main>

    </div>
  )
}
