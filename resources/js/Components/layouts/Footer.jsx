import React from 'react';
import { useNavigate } from 'react-router-dom';

const Footer = () => {
  const navigate = useNavigate();
  
  const handleSignOut = () => {
    // Logic untuk sign out, untuk sementara redirect ke login page
    navigate('/login');
  };
  
  return (
    <footer className="bg-maroon-900 text-white p-4 text-center">
      <button 
        className="bg-maroon-800 hover:bg-maroon-700 py-2 px-4 rounded-md flex items-center mx-auto"
        onClick={handleSignOut}
      >
        <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Sign Out
      </button>
    </footer>
  );
};

export default Footer;