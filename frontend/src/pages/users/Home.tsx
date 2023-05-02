import Sidebar from '@/components/layouts/Sidebar'

export const Home = () => {
  return (
    <div className="layer-1 flex h-screen bg-gray-100">
      <Sidebar />
      <div className="flex-1 p-10">
        <h1 className="text-xl font-semibold">Main Content</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div className="flex-2 p-10">
        <h2 className="text-xl font-semibold">Main2 Content</h2>
        <p>flex2flex2flex2flex2flex2</p>
      </div>
    </div>
  )
}
