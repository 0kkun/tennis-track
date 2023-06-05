import { FC } from 'react'
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
} from '@mui/material'
import { Players } from '../types/player'
import CircularProgress from '@mui/material/CircularProgress'

interface PlayerTableProps {
  players: Players
  isLoading: boolean
}

export const PlayerTable: FC<PlayerTableProps> = ({ players, isLoading }) => {
  return (
    <section>
      {isLoading && (
        <div className="min-h-200 flex items-center justify-center">
          <CircularProgress size={30} color="secondary" />
        </div>
      )}
      {!isLoading && (
        <div className="flex">
          <div className="flex-1 pr-2">
            <h2>Your Favorite</h2>
            <TableContainer component={Paper} style={{ maxHeight: '80vh' }}>
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>Name</TableCell>
                    <TableCell></TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  <TableRow>
                    <TableCell>Carlos Alcaraz</TableCell>
                    <TableCell>
                      <button>Remove</button>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </TableContainer>
          </div>
          <div className="flex-1">
            <h2>Players</h2>
            <TableContainer component={Paper} style={{ maxHeight: '80vh' }}>
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>ID</TableCell>
                    <TableCell>Name</TableCell>
                    <TableCell>Birthday</TableCell>
                    <TableCell>Age</TableCell>
                    <TableCell>Country</TableCell>
                    <TableCell>Gender</TableCell>
                    <TableCell>Backhand Style</TableCell>
                    <TableCell>Dominant Arm</TableCell>
                    <TableCell>Sport Category</TableCell>
                    <TableCell></TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  {players.map((player) => (
                    <TableRow key={player.id}>
                      <TableCell>{player.id}</TableCell>
                      <TableCell>{player.name_en}</TableCell>
                      <TableCell>{player.birthday}</TableCell>
                      <TableCell>{player.age}</TableCell>
                      <TableCell>{player.country}</TableCell>
                      <TableCell>{player.gender}</TableCell>
                      <TableCell>{player.backhand_style}</TableCell>
                      <TableCell>{player.dominant_arm}</TableCell>
                      <TableCell>{player.sport_category}</TableCell>
                      <TableCell>
                        <button>Add</button>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </TableContainer>
          </div>
        </div>
      )}
    </section>
  )
}
