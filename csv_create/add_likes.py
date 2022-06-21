import pandas as pd
import numpy as np

data = pd.read_csv('track.csv')

data.drop('likes', axis=1, inplace=True)

col = np.random.randint(size=len(data), low=10000, high=5000000)
data['likes'] = col
data.to_csv('track_new.csv', sep=',', index=False)

data2= pd.read_csv('track_new.csv', index_col=False)
print(data2.head())