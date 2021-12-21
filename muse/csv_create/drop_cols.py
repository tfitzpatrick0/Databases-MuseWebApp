import pandas as pd

data = pd.read_csv('tracks_features2.csv')

data.drop(['album','artists', 'artist_ids', 'disc_number', 'explicit', 'danceability', 'energy', 'key', 'loudness', 'time_signature', 'year', 'release_date', 'speechiness', 'mode', 'liveness', 'tempo', 'valence', 'track_number', 'instrumentalness', 'acousticness'], axis =1, inplace=True)

data.to_csv('track.csv', sep=',', index=False)



data2= pd.read_csv('track.csv', index_col=False)
print(data2.head())

