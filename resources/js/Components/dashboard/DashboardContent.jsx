import React from 'react';

const DashboardContent = () => {
  // Card colors
  const cardColors = [
    { bg: 'bg-red-500', text: 'text-white' },
    { bg: 'bg-yellow-500', text: 'text-white' },
    { bg: 'bg-purple-500', text: 'text-white' },
    { bg: 'bg-blue-500', text: 'text-white' },
  ];

  return (
    <>
      {/* Dashboard Content */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {/* Card 1 - Yellow */}
        <div className="bg-yellow-500 text-white rounded-lg overflow-hidden shadow-md">
          <div className="p-6">
            <div className="flex justify-between items-center">
              <h3 className="text-lg font-semibold">Card 1</h3>
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <p className="mt-2">Dashboard information here</p>
          </div>
        </div>

        {/* Card 2 - Pink */}
        <div className="bg-pink-500 text-white rounded-lg overflow-hidden shadow-md">
          <div className="p-6">
            <div className="flex justify-between items-center">
              <h3 className="text-lg font-semibold">Card 2</h3>
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <p className="mt-2">Dashboard information here</p>
          </div>
        </div>
      </div>

      {/* Color Cards */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-8">
        {cardColors.map((color, index) => (
          <div key={index} className="flex flex-col items-center">
            <div className={`w-12 h-12 ${color.bg} rounded-lg mb-2 shadow-md`}></div>
            <span className="text-sm text-gray-600">Card {index + 1}</span>
          </div>
        ))}
      </div>
    </>
  );
};

export default DashboardContent;