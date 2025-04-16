import React from 'react';
import { Link, useLocation } from 'react-router-dom';

const Sidebar = () => {
  const location = useLocation();
  
  // Menu items
  const menuItems = [
    { id: 1, title: 'Dashboard', icon: 'chart-bar', path: '/dashboard' },
    { id: 2, title: 'Order Summary', icon: 'clipboard-list', path: '/order-summary' },
    { id: 3, title: 'Inventory Control', icon: 'cube', path: '/inventory-control' },
    { id: 4, title: 'Payment Report', icon: 'cash', path: '/payment-report' },
  ];

  return (
    <aside className="w-64 bg-white h-screen shadow-md">
      <nav className="mt-4">
        <ul>
          {menuItems.map((item) => {
            const isActive = location.pathname === item.path;
            
            return (
              <li key={item.id} className="mb-2">
                <Link
                  to={item.path}
                  className={`flex items-center px-6 py-3 ${
                    isActive ? 'bg-gray-100 border-l-4 border-maroon-900' : ''
                  }`}
                >
                  <svg className="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                  <span className="ml-3 text-gray-800">{item.title}</span>
                </Link>
              </li>
            );
          })}
        </ul>
      </nav>
    </aside>
  );
};

export default Sidebar;